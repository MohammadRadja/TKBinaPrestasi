<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Guru;
use App\Models\NilaiSiswa;
use App\Models\AbsensiSiswa;
use App\Models\Kelas;
use App\Models\AktivitasHarian;
use App\Models\SuratPemberitahuan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Exports\NilaiSiswaExport;
use App\Exports\GuruExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->is('admin/*')) {
                $pengguna = Pengguna::find(session('pengguna_id'));
                if (!$pengguna || $pengguna->role !== 'admin') {
                    return redirect()->route('login')->with('error', 'Akses ditolak, silakan login sebagai admin.');
                }
            }
            return $next($request);
        });
    }

    /** ========================== 🟢 SISWA ========================== */
    public function dataSiswa()
    {
        $siswa = Siswa::with('pengguna')->get();
        $kelasList = Kelas::pluck('nama_kelas', 'id');

        return view('admin.data-siswa', compact('siswa', 'kelasList'));
    }

    public function tambahSiswa(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'kelas_id' => 'required|exists:kelas,id',
                'nama_panggilan' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_tanggal_lahir' => 'required|string|max:255',
                'agama' => 'required|string|max:255',
                'anak_ke' => 'required|integer',
                'nama_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:255',
                'pekerjaan_ayah' => 'required|string|max:255',
                'pekerjaan_ibu' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
                'alamat' => 'required|string|max:255',
                'username' => 'required|string|unique:pengguna|max:255',
                'email' => 'required|email|unique:pengguna|max:255',
                'password' => 'required|string|min:6|max:255',
            ]);

            $pengguna = Pengguna::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'siswa',
            ]);

            Siswa::create(array_merge($validated, ['pengguna_id' => $pengguna->id]));

            return response()->json(['success' => true, 'message' => 'Data siswa berhasil ditambahkan.']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateSiswa(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string|max:100',
                'kelas_id' => 'required|exists:kelas,id',
                'nama_panggilan' => 'required|string|max:100',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_tanggal_lahir' => 'required|string',
                'agama' => 'required|string',
                'anak_ke' => 'required|integer',
                'nama_ayah' => 'required|string|max:100',
                'nama_ibu' => 'required|string|max:100',
                'pekerjaan_ayah' => 'required|string',
                'pekerjaan_ibu' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'alamat' => 'required|string',
            ]);

            Pengguna::findOrFail($id)->update(['nama_lengkap' => $request->nama_lengkap]);
            Siswa::where('pengguna_id', $id)->update($request->except(['_token', '_method']));

            return response()->json(['success' => true, 'message' => 'Data siswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteSiswa($id)
    {
        try {
            Siswa::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Data siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportSiswa()
    {
        return Excel::download(new SiswaExport(), 'data_siswa.xlsx');
    }

    /** ========================== 🟢 Kelas ========================== */
    public function dataKelas()
    {
        $kelas = Kelas::with('guru')->get();
        $guruList = Guru::pluck('nama_lengkap', 'id');

        return view('admin.data-kelas', compact('kelas', 'guruList'));
    }

    public function tambahKelas(Request $request)
    {
        try {
            $validated = $request->validate([
                'guru_id' => 'required|exists:guru,id',
                'nama_kelas' => 'required|string|max:100',
                'tingkat' => 'required|in:A,B',
                'kapasitas' => 'required|integer|min:1',
                'tahun_ajaran' => 'required|string|max:20',
            ]);

            Kelas::create($validated);

            return response()->json(['success' => true, 'message' => 'Data Kelas berhasil ditambahkan.']);
        } catch (ValidationException $e) {
            Log::error($e);
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateKelas(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'guru_id' => 'required|exists:guru,id',
                'nama_kelas' => 'required|string|max:100',
                'tingkat' => 'required|in:A,B',
                'kapasitas' => 'required|integer|min:1',
                'tahun_ajaran' => 'required|string|max:20',
            ]);

            $kelas = Kelas::findOrFail($id);
            $kelas->update($validated);

            return response()->json(['success' => true, 'message' => 'Data Kelas berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteKelas($id)
    {
        try {
            Kelas::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Data Kelas berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🟢 GURU ========================== */
    public function dataGuru()
    {
        $guru = Guru::with('pengguna', 'kelas')->get();
        $kelasList = Kelas::all()->mapWithKeys(function ($kelas) {
            return [
                $kelas->id => $kelas->nama_kelas . ' - Tingkat: ' . $kelas->tingkat . ' - Tahun Ajaran: ' . $kelas->tahun_ajaran,
            ];
        });
        return view('admin.data-guru', compact('guru', 'kelasList'));
    }

    public function tambahGuru(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'kelas_id' => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'nullable|date',
                'agama' => 'nullable|string|max:100',
                'pendidikan_terakhir' => 'nullable|string|max:100',
                'no_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:255',
                'username' => 'required|string|unique:pengguna|max:255',
                'email' => 'required|email|unique:pengguna|max:255',
                'password' => 'required|string|min:6|max:255',
            ]);

            $pengguna = Pengguna::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'guru',
            ]);

            Guru::create(array_merge($validated, ['pengguna_id' => $pengguna->id]));

            return response()->json(['success' => true, 'message' => 'Data guru berhasil ditambahkan.']);
        } catch (ValidationException $e) {
            Log::error($e);
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateGuru(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'kelas_id' => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'nullable|date',
                'agama' => 'nullable|string|max:100',
                'pendidikan_terakhir' => 'nullable|string|max:100',
                'no_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:255',
            ]);

            Pengguna::findOrFail($id)->update(['nama_lengkap' => $request->nama_lengkap]);
            Guru::where('pengguna_id', $id)->update($request->except(['_token', '_method']));

            return response()->json(['success' => true, 'message' => 'Data guru berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteGuru($id)
    {
        try {
            Guru::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Data guru berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportGuru()
    {
        return Excel::download(new GuruExport(), 'data_guru.xlsx');
    }

    /** ========================== 🟢 ABSENSI SISWA ========================== */
    public function dataAbsensi()
    {
        $absensi = AbsensiSiswa::with(['guru', 'siswa', 'kelas'])
            ->latest()
            ->get();
        return view('admin.absensi-siswa', compact('absensi'));
    }

    /** ========================== 🟢 NILAI SISWA ========================== */
    public function dataNilai()
    {
        $nilai = NilaiSiswa::with('siswa', 'guru')->get();
        $siswaList = Siswa::pluck('nama_lengkap', 'id');
        $guruList = Guru::pluck('nama_lengkap', 'id');
        $kelasList = Kelas::all()->mapWithKeys(function ($kelas) {
            return [
                $kelas->id => $kelas->nama_kelas . ' - Tingkat: ' . $kelas->tingkat . ' - Tahun Ajaran: ' . $kelas->tahun_ajaran,
            ];
        });

        return view('admin.nilai-siswa', compact('nilai', 'siswaList', 'guruList', 'kelasList'));
    }

    public function tambahNilai(Request $request)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'guru_id' => 'required|exists:guru,id',
                'kelas_id' => 'required|exists:kelas,id',
                'mata_pelajaran' => 'required|string|max:100',
                'nilai' => 'required|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'tanggal_input' => 'required|date',
            ]);
            $data['id'] = Str::uuid();

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
                'guru_id' => 'required|exists:guru,id',
                'kelas_id' => 'required|exists:kelas,id',
                'mata_pelajaran' => 'required|string|max:100',
                'nilai' => 'required|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'tanggal_input' => 'required|date',
            ]);

            NilaiSiswa::findOrFail($id)->update($data);
            return response()->json(['success' => true, 'message' => 'Nilai siswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteNilai($id)
    {
        try {
            NilaiSiswa::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Nilai siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportNilai()
    {
        return Excel::download(new NilaiSiswaExport(), 'data_nilai.xlsx');
    }

    /** ========================== 🟢 AKTIVITAS SISWA ========================== */
    public function dataAktivitas()
    {
        $aktivitas = AktivitasHarian::with('siswa', 'guru', 'kelas')->get();
        $siswaList = Siswa::pluck('nama_lengkap', 'id');
        $guruList = Guru::pluck('nama_lengkap', 'id');

        $kelasList = Kelas::all()->mapWithKeys(function ($kelas) {
            return [
                $kelas->id => $kelas->nama_kelas . ' - Tingkat: ' . $kelas->tingkat . ' - Tahun Ajaran: ' . $kelas->tahun_ajaran,
            ];
        });

        return view('admin.aktivitas-siswa', compact('aktivitas', 'siswaList', 'guruList', 'kelasList'));
    }

    public function tambahAktivitas(Request $request)
    {
        try {
            $data = $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'guru_id' => 'required|exists:guru,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'aktivitas' => 'required|string',
                'catatan' => 'nullable|string',
                'foto_aktivitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            $data['id'] = Str::uuid();
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
                'guru_id' => 'required|exists:guru,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'aktivitas' => 'required|string',
                'catatan' => 'nullable|string',
                'foto_aktivitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $aktivitas = AktivitasHarian::findOrFail($id);
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
            $aktivitas = AktivitasHarian::findOrFail($id);
            $this->hapusFoto($aktivitas->foto_aktivitas);
            $aktivitas->delete();
            return response()->json(['success' => true, 'message' => 'Aktivitas harian berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🟢 Mading ========================== */
    public function dataMading()
    {
        $mading = SuratPemberitahuan::all();
        return view('admin.mading', compact('mading'));
    }

    public function tambahMading(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'target_role' => 'required|string',
            ]);

            $pengguna_id = session('pengguna_id');
            if (!$pengguna_id) {
                return response()->json(['success' => false, 'message' => 'Anda harus login terlebih dahulu'], 401);
            }

            SuratPemberitahuan::create([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'dibuat_oleh' => $pengguna_id,
                'target_role' => $request->target_role,
            ]);

            return response()->json(['success' => true, 'message' => 'Surat Pemberitahuan berhasil dibuat.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateMading(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'target_role' => 'required|string',
            ]);

            SuratPemberitahuan::findOrFail($id)->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'dibuat_oleh' => Auth::id(),
                'target_role' => $request->target_role,
            ]);

            return response()->json(['success' => true, 'message' => 'Surat Pemberitahuan berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteMading($id)
    {
        try {
            SuratPemberitahuan::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Surat Pemberitahuan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🟢 PEMBAYARAN ========================== */
    public function dataPembayaran()
    {
        $pembayaran = Pembayaran::with('siswa')->get();
        return view('admin.pembayaran', compact('pembayaran'));
    }

    public function approvePembayaran($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->update(['status' => 'lunas']);
            return response()->json(['success' => true, 'message' => 'Pembayaran telah disetujui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function rejectPembayaran($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->update(['status' => 'gagal']);
            return response()->json(['success' => true, 'message' => 'Pembayaran telah ditolak.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🛠️ PRIVATE HELPER ========================== */
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
