<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Obat;
use App\Models\ObatRekamMedis;
use App\Models\PengambilanObat;
use App\Models\Puskesmas;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use App\Services\TwilioService;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Else_;
use Vonage\SMS\Message\SMS;

class PengambilanObatController extends Controller
{
  public function index(Request $request)
  {
    $pengambilanObat = PengambilanObat::query();
    $pengambilanObat->whereHas('rekamMedis', fn($q) => $q->where('status', 'menunggu_obat'));
    $pengambilanObat->orderBy('waktu_pengambilan', 'asc');
    return view('pages.pengambilan-obat.index', [
      'pengambilanObats' => $pengambilanObat->with(['rekamMedis.pendaftaran.pasien'])->latest()->get(),
    ]);
  }

  public function edit(PengambilanObat $pengambilanObat)
  {
    $obatRekamMedis = ObatRekamMedis::where('rekam_medis_id', $pengambilanObat->rekam_medis_id)->get();
    return view('pages.pengambilan-obat.edit', [
      'pengambilanObat' => $pengambilanObat,
      'obatRekamMedis' => $obatRekamMedis,
      'rekamMedis' => RekamMedis::with(['pendaftaran.pasien'])->find($pengambilanObat->rekam_medis_id),
    ]);
  }

  public function update(Request $request, PengambilanObat $pengambilanObat)
  {
    $request->validate([
      'status' => 'required|in:menunggu_obat,selesai',
      'waktu_pengambilan' => 'required',
      'catatan' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();
    try {
      $pengambilanObat->update([
        'waktu_pengambilan' => $request->waktu_pengambilan,
        'catatan' => $request->catatan,
      ]);

      $pengambilanObat->rekamMedis->update([
        'status' => $request->status,
      ]);

      if ($request->status === 'selesai') {
        foreach ($pengambilanObat->rekamMedis->obatRekamMedis as $obat) {
          Obat::where('id', $obat->obat_id)->decrement('stok', $obat->jumlah);
        }
      }

      DB::commit();
      return redirect()->route('pengambilan-obat.index')->with('success', 'Data pengambilan obat berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage())->withInput();
    }
  }

  public function sendNotifVonage(Request $request, PengambilanObat $pengambilan_obat)
  {
    $namaPasien = $pengambilan_obat->rekamMedis->pendaftaran->pasien->name;
    $noTelepon  = $pengambilan_obat->rekamMedis->pendaftaran->pasien->telepon;
    $noTelepon = Utilities::getTeleponFormatted($noTelepon);
    // $noTelepon = "6285315755352"; // Ganti dengan nomor telepon yang valid
    $waktuPengambilan = $pengambilan_obat->waktu_pengambilan_formatted;

    $messageText = "Halo $namaPasien! Silakan ambil obat Anda pada $waktuPengambilan. Terima kasih.";

    try {
      $pengambilan_obat->update(['is_notified' => true]);

      $basic  = new \Vonage\Client\Credentials\Basic("b11f0df6", "Mxn0ilDfqIhTrBYK");
      $client = new \Vonage\Client($basic);

      $response = $client->sms()->send(
        new \Vonage\SMS\Message\SMS("6285315755352", 'Puskesmas', $messageText)
      );

      $message = $response->current();

      if ($message->getStatus() == 0) {
        return response()->json(['success' => true, 'message' => 'SMS berhasil dikirim ke ' . $noTelepon]);
      } else {
        return response()->json(['success' => false, 'message' => 'Gagal kirim SMS. Status: ' . $message->getStatus()]);
      }
    } catch (\Throwable $th) {
      return response()->json(['success' => false, 'message' => 'Gagal kirim SMS: ' . $th->getMessage()]);
    }
  }

  public function sendNotifTwilio(Request $request, PengambilanObat $pengambilan_obat, TwilioService $twilio)
  {
    $nama = $pengambilan_obat->rekamMedis->pendaftaran->pasien->name;
    // $telepon = $pengambilan_obat->rekamMedis->pendaftaran->pasien->telepon;
    $teleponTujuan = '+62 853 1575 5352';
    $waktu = $pengambilan_obat->waktu_pengambilan_formatted;

    try {

      $pengambilan_obat->update(['is_notified' => true]);

      $sid = getenv('TWILIO_SID');
      $token = getenv('TWILIO_TOKEN');
      $twilio = new TwilioClient($sid, $token);

      $message = "Halo, $nama! Silakan ambil obat Anda pada $waktu. Terima kasih.";

      $twilio->messages->create(
        '+6285315755352', // Ganti dengan nomor telepon tujuan
        [
          'from' => getenv('TWILIO_FROM'),
          'body' => $message
        ]
      );

      return response()->json([
        'success' => true,
        'message' => 'Notifikasi berhasil dikirim!',
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal kirim notifikasi: ' . $e->getMessage(),
      ]);
    }
  }

  public function sendNotifWablas(Request $request, PengambilanObat $pengambilan_obat)
  {
    $namaPasien = $pengambilan_obat->rekamMedis->pendaftaran->pasien->name;
    $noTelepon  = $pengambilan_obat->rekamMedis->pendaftaran->pasien->telepon;
    // $noTelepon  = '+62 812-4067-0863';
    $noTelepon = Utilities::getTeleponFormatted($noTelepon); // Pastikan format: 628xxxx

    $waktuPengambilan = $pengambilan_obat->waktu_pengambilan_formatted;
    $messageText = "Halo $namaPasien! Silakan ambil obat Anda pada $waktuPengambilan. Terima kasih.";

    $token = env('WABLAS_TOKEN');
    $secretKey = env('WABLAS_SECRET');

    $authorization = $token . '.' . $secretKey;

    try {
      $pengambilan_obat->update(['is_notified' => true]);

      $response = Http::withHeaders([
        'Authorization' => $authorization,
      ])->asForm()->post('https://sby.wablas.com/api/send-message', [
        'phone' => $noTelepon,
        'message' => $messageText,
        'isGroup' => 'false',
      ]);

      $result = $response->json();

      if ($result['status'] ?? false) {
        return response()->json([
          'success' => true,
          'message' => 'Pesan WA berhasil dikirim ke ' . $noTelepon,
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Gagal mengirim pesan WA. ' . ($result['message'] ?? 'Unknown error'),
        ]);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal kirim pesan: ' . $th->getMessage(),
      ]);
    }
  }
}
