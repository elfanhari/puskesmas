<?php

namespace App\Providers;

use App\Models\Puskesmas;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $puskesmas = Puskesmas::first();
    view()->share('puskesmas', $puskesmas);

    Gate::define('admin', function (User $user) {
      return $user->isAdmin();
    });

    Gate::define('petugas', function (User $user) {
      return $user->isPetugas();
    });

    Gate::define('dokter', function (User $user) {
      return $user->isDokter();
    });

    Gate::define('kepala', function (User $user) {
      return $user->isKepala();
    });
  }
}
