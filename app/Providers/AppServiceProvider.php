<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $role = null;
            $notifikasi = collect(); // default kosong

            if (Session::has('pengguna_id')) {
                $pengguna = Pengguna::find(Session::get('pengguna_id'));
                if ($pengguna) {
                    $role = $pengguna->role;
                    // Ambil notifikasi terbaru (misalnya 5 terakhir)
                    $notifikasi = $pengguna->notifications()->latest()->take(5)->get();
                }
            }

            $view->with([
                'role' => $role,
                'notifikasi' => $notifikasi,
            ]);
        });
    }
}
