<?php

namespace App\Http\Controllers;

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
use PhpParser\Node\Stmt\Else_;
use Vonage\SMS\Message\SMS;

class PengambilanObatController extends Controller
{
  public function index(Request $request)
  {
    $pengambilanObat = PengambilanObat::query();
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

  //   public function sendNotif(Request $request, PengambilanObat $pengambilan_obat)
  //   {
  //     $namaPasien = $pengambilan_obat?->rekamMedis?->pendaftaran?->pasien?->name;
  //     // $noTelepon = $pengambilan_obat?->rekamMedis?->pendaftaran?->pasien?->telepon;
  //     $noTelepon = "6285315755352";
  //     $waktuPengambilan = $pengambilan_obat->waktu_pengambilan_formatted;
  //     $puskesmas = Puskesmas::first();
  //
  //     if (!$namaPasien || !$noTelepon || !$waktuPengambilan) {
  //       return response()->json([
  //         'success' => false,
  //         'message' => 'Data tidak lengkap untuk mengirim notifikasi.',
  //       ], 400);
  //     }
  //
  //     DB::beginTransaction();
  //
  //     try {
  //       $messageText = "Halo, {$namaPasien}! Silakan ambil obat pada tanggal {$waktuPengambilan}. Terima kasih.";
  //
  //       //       $basic  = new \Vonage\Client\Credentials\Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
  //       //       $client = new \Vonage\Client($basic);
  //       //
  //       //       $response = $client->sms()->send(
  //       //         new \Vonage\SMS\Message\SMS($noTelepon, $puskesmas->name, $messageText)
  //       //       );
  //       //
  //       //       $message = $response->current();
  //
  //       return (new VonageMessage)
  //         ->content($messageText)
  //         ->from('6285315755352');
  //
  //       // if ($message->getStatus() != 0) {
  //       //   return response()->json([
  //       //     'success' => false,
  //       //     'message' => "Gagal kirim SMS. Status: " . $message->getStatus(),
  //       //   ]);
  //       // }
  //
  //       DB::commit();
  //
  //       return response()->json([
  //         'success' => true,
  //         'message' => 'Notifikasi berhasil dikirim!',
  //       ]);
  //     } catch (\Throwable $th) {
  //       DB::rollBack();
  //
  //       return response()->json([
  //         'success' => false,
  //         'message' => 'Terjadi kesalahan saat mengirim notifikasi: ' . $th->getMessage(),
  //       ], 500);
  //     }
  //   }

  public function sendNotif(Request $request, PengambilanObat $pengambilan_obat)
  {
    $namaPasien = $pengambilan_obat->rekamMedis->pendaftaran->pasien->name;
    // $noTelepon  = $pengambilan_obat->rekamMedis->pendaftaran->pasien->telepon;
    $noTelepon = "6285315755352"; // Ganti dengan nomor telepon yang valid
    $waktuPengambilan = $pengambilan_obat->waktu_pengambilan_formatted;

    $messageText = "Halo $namaPasien! Silakan ambil obat Anda pada $waktuPengambilan. Terima kasih.";

    try {
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
}
