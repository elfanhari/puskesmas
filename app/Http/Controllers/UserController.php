<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($role, Request $request)
  {
    $users = User::where('role', $role)->latest();
    if ($request->is_aktif) $users->where('is_aktif', $request->is_aktif);
    $users = $users->latest()->get();
    $roleFormatted = Utilities::getRoleFormatted($role);
    return view('pages.user.index', compact('users', 'role', 'roleFormatted'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($role)
  {
    $roleFormatted = Utilities::getRoleFormatted($role);
    $user = new User([
      'is_aktif' => 1
    ]);
    return view('pages.user.create', compact('role', 'roleFormatted', 'user'));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $role)
  {
    $request->validate([
      'name' => 'required',
      'is_aktif' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required'
    ]);


    DB::beginTransaction();
    try {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $role,
        'is_aktif' => $request->is_aktif,
        'password' => $request->password
      ]);

      if ($role === 'dokter') {
        Dokter::create([
          'user_id' => $user->id,
          'name' => $request->name,
        ]);
      }

      DB::commit();
      return redirect()->route('user.index', $role)->withSuccess('Data berhasil ditambahkan!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show($role, User $user)
  {
    $roleFormatted = Utilities::getRoleFormatted($role);
    return view('pages.user.show', [
      'user' => $user,
      'roleFormatted' => $roleFormatted
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit($role, User $user)
  {
    $roleFormatted = Utilities::getRoleFormatted($role);
    return view('pages.user.edit', compact('user', 'role', 'roleFormatted'));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $role, User $user)
  {
    $request->validate([
      'name' => 'required',
      'is_aktif' => 'required',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable'
    ]);

    DB::beginTransaction();
    try {
      $data = $request->only(['name', 'email', 'is_aktif']);
      if ($request->filled('password')) {
        $data['password'] = $request->password;
      }
      $user->update($data);
      if ($role === 'dokter') {
        $user->dokter->update([
          'name' => $request->name,
        ]);
      }
      DB::commit();
      return redirect()->route('user.index', $role)->withSuccess('Data berhasil diperbarui!');
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy($role, User $user)
  {
    DB::beginTransaction();
    try {
      $user->delete();
      DB::commit();

      return back()->withSuccess("{$user->name} berhasil dihapus!");
    } catch (\Throwable $th) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}
