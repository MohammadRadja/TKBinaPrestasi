<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use App\Models\NilaiSiswa;
use App\Models\SiswaBerkas;
use App\Models\SuratPemberitahuan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $penggunaId = session('pengguna_id');
        $pengguna = Pengguna::findOrFail($penggunaId);
        $role = $pengguna->role;

        // Dashboard
        if ($role === 'admin') {
            $data = [
                'mading' => SuratPemberitahuan::with('admin')->latest()->get(),
                'jumlah_siswa' => Pengguna::where('role', 'siswa')->count(),
                'jumlah_guru' => Pengguna::where('role', 'guru')->count(),
                'jumlah_mading' => SuratPemberitahuan::count(),
                'jumlah_berkas' => SiswaBerkas::count(),
                'jumlah_kelas' => Kelas::count(),

                'ranking_per_kelas' => Siswa::with(['kelas', 'nilai'])
                    ->get()
                    ->groupBy('kelas_id')
                    ->map(function (Collection $siswaGroup) {
                        return $siswaGroup->sortByDesc(fn($s) => $s->rata_rata_nilai)->take(5);
                    }),
            ];

            return view('admin.dashboard', $data);
        } elseif ($role === 'guru') {
            $data['ranking_per_kelas'] = $pengguna->guru->rankingPerKelas();
            $data['mading'] = SuratPemberitahuan::whereIn('target_role', ['guru', 'semua'])
                ->with('admin')
                ->latest()
                ->take(5)
                ->get();
            $data['jumlah_siswa'] = Pengguna::where('role', 'siswa')->count();
            $data['aktivitas_guru'] = $pengguna->guru->aktivitas()->with('siswa')->latest()->take(5)->get();
            $data['nilai_siswa'] = $pengguna->guru->nilai()->with('siswa')->latest()->take(10)->get();

            return view('guru.dashboard', $data);
        } else {
            $data['siswa'] = Siswa::where('pengguna_id', $penggunaId)->first();
            $data['mading'] = SuratPemberitahuan::whereIn('target_role', ['siswa', 'semua'])
                ->with('admin')
                ->latest()
                ->take(5)
                ->get();
            return view('siswa.dashboard', $data);
        }
    }
}
