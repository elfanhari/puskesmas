<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query();
        if ($request->role) $users->where('role', $request->role);
        return view('pages.user.index',[
          'users' => $users->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create',[
          // 'users' => User::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
          'name' => 'required',
          'email' => 'required|unique:users,email',
          'role' => 'required',
          'password' => 'required',
        ]);

        User::create($request->all());
        return redirect(route('user.index'))->withSuccess('Data Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      return view('pages.user.show',[
        'user' => $user,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      return view('pages.user.edit',[
        'user' => $user,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
          'name' => 'required',
          'email' => 'required|unique:users,email,' . $user->id,
          'role' => 'required',
          'password' => 'nullable',
        ]);

        $user->update($request->all());
        return redirect(route('user.index'))->withSuccess('Data Berhasil dipebarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $flashMessage = $user->name . ' Berhasil dihapus!';
        $user->delete();
        return redirect(route('user.index'))->withSuccess($flashMessage);
    }
}
