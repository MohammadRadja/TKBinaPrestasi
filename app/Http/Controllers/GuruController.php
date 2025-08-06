<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Pengguna;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\AbsensiSiswa;
use App\Models\NilaiSiswa;
use App\Models\AktivitasHarian;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->is('guru/*')) {
                $pengguna = Pengguna::find(session('pengguna_id'));
                if (!$pengguna || $pengguna->role !== 'guru') {
                    return redirect()->route('login')->with('error', 'Akses ditolak, silakan login sebagai guru.');
                }
            }
            return $next($request);
        });
    }

    /** ========================== 🟢 ABSENSI SISWA ========================== */
    public function dataAbsensi()
    {
        // Ambil ID guru dari session
        $guruId = $this->getGuruIdFromSession();

        // Ambil semua kelas yang diampu guru ini
        $kelas = Kelas::where('guru_id', $guruId)->get();

        // Ambil ID kelas yang diampu guru ini
        $kelasIds = $kelas->pluck('id');

        // Ambil aktivitas harian yang dibuat oleh guru
        $absensi = AbsensiSiswa::with('siswa', 'guru', 'kelas')->where('guru_id', $guruId)->get();

        // Ambil seluruh siswa dari kelas yang diampu guru
        $siswaList = Siswa::whereIn('kelas_id', $kelasIds)->pluck('nama_lengkap', 'id');

        // Format daftar kelas untuk dropdown atau tampilan
        $kelasList = $kelas->mapWithKeys(function ($kelas) {
            $label = "{$kelas->nama_kelas} - Tingkat: {$kelas->tingkat} - Tahun Ajaran: {$kelas->tahun_ajaran}";
            return [$kelas->id => $label];
        });

        return view('guru.absensi-siswa', compact('absensi', 'siswaList', 'kelasList'));
    }

    public function tambahAbsensi(Request $request)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
                'keterangan' => 'nullable|string',
            ]);

            // Cek duplikat absensi pada tanggal untuk siswa yang sama
            $exists = AbsensiSiswa::where('siswa_id', $data['siswa_id'])->whereDate('tanggal', $data['tanggal'])->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Absensi siswa pada tanggal tersebut sudah ada.',
                ]);
            }

            $data['id'] = Str::uuid();
            $data['guru_id'] = $this->getGuruIdFromSession();

            AbsensiSiswa::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil ditambahkan.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function updateAbsensi(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
                'keterangan' => 'nullable|string',
            ]);

            $guruId = $this->getGuruIdFromSession();

            $absensi = AbsensiSiswa::where('id', $id)->where('guru_id', $guruId)->firstOrFail();

            $absensi->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function deleteAbsensi($id)
    {
        try {
            $guruId = $this->getGuruIdFromSession();

            $absensi = AbsensiSiswa::where('id', $id)->where('guru_id', $guruId)->firstOrFail();

            $absensi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /** ========================== 🟢 NILAI SISWA ========================== */
    public function dataNilai()
    {
        // Ambil ID guru berdasarkan pengguna yang login
        $guruId = $this->getGuruIdFromSession();

        // Ambil semua nilai yang diajarkan oleh guru
        $nilaiList = NilaiSiswa::with('siswa', 'guru')->where('guru_id', $guruId)->get();

        // Ambil daftar siswa yang memiliki nilai dari guru tersebut
        $siswaList = Siswa::whereHas('nilai', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })->pluck('nama_lengkap', 'id');

        // Ambil daftar kelas yang berkaitan dengan guru tersebut
        $kelasList = Kelas::whereHas('nilai', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })
            ->get()
            ->mapWithKeys(function ($kelas) {
                $label = "{$kelas->nama_kelas} - Tingkat: {$kelas->tingkat} - Tahun Ajaran: {$kelas->tahun_ajaran}";
                return [$kelas->id => $label];
            });

        // Tampilkan view dengan data yang sudah difilter
        return view('guru.nilai-siswa', compact('nilaiList', 'siswaList', 'kelasList'));
    }

    public function tambahNilai(Request $request)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'kelas_id' => 'required|exists:kelas,id',
                'mata_pelajaran' => 'required|string|max:100',
                'nilai' => 'required|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'tanggal_input' => 'required|date',
            ]);
            $data['id'] = Str::uuid();
            $data['guru_id'] = $this->getGuruIdFromSession();

            NilaiSiswa::create($data);
            return response()->json(['success' => true, 'message' => 'Nilai siswa berhasil ditambahkan.']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateNilai(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'kelas_id' => 'required|exists:kelas,id',
                'mata_pelajaran' => 'required|string|max:100',
                'nilai' => 'required|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'tanggal_input' => 'required|date',
            ]);

            $guruId = $this->getGuruIdFromSession();

            $nilai = NilaiSiswa::where('id', $id)->where('guru_id', $guruId)->firstOrFail();

            $nilai->update($data);

            return response()->json(['success' => true, 'message' => 'Nilai siswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteNilai($id)
    {
        try {
            $guruId = $this->getGuruIdFromSession();

            $nilai = NilaiSiswa::where('id', $id)->where('guru_id', $guruId)->firstOrFail();

            $nilai->delete();

            return response()->json(['success' => true, 'message' => 'Nilai siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🟢 AKTIVITAS SISWA ========================== */
    public function dataAktivitas()
    {
        // Ambil ID guru dari session
        $guruId = $this->getGuruIdFromSession();

        // Ambil semua kelas yang diampu guru ini
        $kelas = Kelas::where('guru_id', $guruId)->get();

        // Ambil ID kelas yang diampu guru ini
        $kelasIds = $kelas->pluck('id');

        // Ambil aktivitas harian yang dibuat oleh guru
        $aktivitas = AktivitasHarian::with('siswa', 'guru')->where('guru_id', $guruId)->get();

        // Ambil seluruh siswa dari kelas yang diampu guru
        $siswaList = Siswa::whereIn('kelas_id', $kelasIds)->pluck('nama_lengkap', 'id');

        // Format daftar kelas untuk dropdown atau tampilan
        $kelasList = $kelas->mapWithKeys(function ($kelas) {
            $label = "{$kelas->nama_kelas} - Tingkat: {$kelas->tingkat} - Tahun Ajaran: {$kelas->tahun_ajaran}";
            return [$kelas->id => $label];
        });

        return view('guru.aktivitas-siswa', compact('aktivitas', 'siswaList', 'kelasList'));
    }

    public function tambahAktivitas(Request $request)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'tanggal' => 'required|date',
                'aktivitas' => 'required|string',
                'catatan' => 'nullable|string',
                'foto_aktivitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            // Cek jika aktivitas untuk siswa dan tanggal sudah ada
            $existing = AktivitasHarian::where('siswa_id', $data['siswa_id'])->whereDate('tanggal', $data['tanggal'])->exists();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aktivitas untuk siswa ini pada tanggal tersebut sudah ada.',
                ]);
            }

            $data['id'] = Str::uuid();
            $data['guru_id'] = $this->getGuruIdFromSession();
            $data['foto_aktivitas'] = $this->uploadFoto($request);

            AktivitasHarian::create($data);
            return response()->json(['success' => true, 'message' => 'Aktivitas harian berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateAktivitas(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'tanggal' => 'required|date',
                'aktivitas' => 'required|string',
                'catatan' => 'nullable|string',
                'foto_aktivitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            $guruId = $this->getGuruIdFromSession();
            $aktivitas = AktivitasHarian::where('id', $id)->where('guru_id', $guruId)->firstOrFail();
            if ($request->hasFile('foto_aktivitas')) {
                $this->hapusFoto($aktivitas->foto_aktivitas);
                $data['foto_aktivitas'] = $this->uploadFoto($request);
            }

            $aktivitas->update($data);
            return response()->json(['success' => true, 'message' => 'Aktivitas harian berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteAktivitas($id)
    {
        try {
            $guruId = $this->getGuruIdFromSession();
            $aktivitas = AktivitasHarian::where('id', $id)->where('guru_id', $guruId)->findOrFail($id);
            $this->hapusFoto($aktivitas->foto_aktivitas);
            $aktivitas->delete();
            return response()->json(['success' => true, 'message' => 'Aktivitas harian berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🛠️ PRIVATE HELPER ========================== */
    private function getGuruIdFromSession()
    {
        $penggunaId = session('pengguna_id');
        return Guru::where('pengguna_id', $penggunaId)->value('id');
    }

    private function uploadFoto($request)
    {
        if ($request->hasFile('foto_aktivitas')) {
            $filename = time() . '_' . $request->file('foto_aktivitas')->getClientOriginalName();
            $request->file('foto_aktivitas')->move(public_path('img/aktivitas'), $filename);
            return $filename;
        }
        return null;
    }

    private function hapusFoto($filename)
    {
        $path = public_path('img/aktivitas/' . $filename);
        if ($filename && file_exists($path)) {
            unlink($path);
        }
    }
}
