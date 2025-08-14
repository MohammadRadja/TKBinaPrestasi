<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Siswa;
use App\Models\SiswaBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Exception;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use App\Models\Kelas;

class AuthController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /* ========================== FORGOT PASSWORD ========================== */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'new_password' => 'required|min:6|confirmed',
            ],
            [
                'new_password.confirmed' => 'Password baru dan konfirmasi password tidak cocok.',
            ],
        );

        try {
            $user = Pengguna::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak ditemukan.']);
            }

            $user->update(['password' => Hash::make($request->new_password)]);

            return back()->with('success', 'Password Anda telah diperbarui.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    /* ========================== PROFIL ========================== */
    public function profil()
    {
        $pengguna = Pengguna::findOrFail(Session::get('pengguna_id'));
        return view('auth.profil', compact('pengguna'));
    }

    /* ========================== REGISTER SISWA ========================== */
    public function showRegisterForm()
    {
        $kelasList = Kelas::select('tingkat')
            ->distinct()
            ->orderBy('tingkat')
            ->pluck('tingkat');

        return view('auth.register', compact('kelasList'));
    }

    public function register(Request $request)
    {
        $this->validateRegister($request);
        Log::info('Proses pendaftaran dimulai', ['email' => $request->email, 'username' => $request->username]);

        DB::beginTransaction();
        try {
            // 1. Simpan akun pengguna
            $pengguna = Pengguna::create([
                'id' => Str::uuid(),
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
            ]);
            Log::info('Akun pengguna berhasil dibuat', ['pengguna_id' => $pengguna->id]);

            // 2. Simpan biodata siswa
            $siswa = Siswa::create([
                'pengguna_id' => $pengguna->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'kelas_id' => Kelas::where('tingkat', $request->kelas)->first()->id,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
                'agama' => $request->agama,
                'anak_ke' => $request->anak_ke,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
            Log::info('Biodata siswa berhasil disimpan', ['siswa_id' => $siswa->id]);

            // 3. Upload semua berkas
            $this->saveBerkas($request, $siswa->id, 'akta_kelahiran', 'Akta Kelahiran');
            $this->saveBerkas($request, $siswa->id, 'kartu_keluarga', 'Kartu Keluarga');
            $this->saveBerkas($request, $siswa->id, 'pas_foto', 'Pas Foto');
            $this->saveBerkas($request, $siswa->id, 'ktp_ortu', 'KTP Orang Tua');
            if ($request->hasFile('ijazah_tk')) {
                $this->saveBerkas($request, $siswa->id, 'ijazah_tk', 'Ijazah TK/PAUD');
                Log::info('Ijazah TK/PAUD berhasil diupload', ['siswa_id' => $siswa->id]);
            }

            // Kirim Notifikasi ke Admin
            $this->notificationService->toRole('admin', 'Pendaftaran Siswa Baru', "Siswa {$siswa->nama_lengkap} baru saja mendaftar.", 'info');
            Log::info('Notifikasi admin berhasil dikirim', ['siswa' => $siswa->nama_lengkap]);

            DB::commit();
            Log::info('Pendaftaran siswa berhasil', ['siswa_id' => $siswa->id]);

            return redirect()->route('login')->with('success', 'Akun Anda berhasil dibuat. Silakan login.');
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Kesalahan database saat pendaftaran', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan ke database.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Kesalahan umum saat pendaftaran', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.']);
        }
    }

    /* ========================== LOGIN ========================== */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $pengguna = Pengguna::where('username', $request->username)->first();

            if ($pengguna && Hash::check($request->password, $pengguna->password)) {
                Session::put('pengguna_id', $pengguna->id);
                Session::put('pengguna_username', $pengguna->username);

                // Tambahkan flash message untuk alert
                if ($pengguna->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil, selamat datang Admin!');
                } else {
                    return redirect()->route('siswa.dashboard')->with('success', 'Login berhasil, selamat datang!');
                }
            }

            return back()->withErrors(['login_failed' => 'Username atau password salah.']);
        } catch (Exception $e) {
            Log::error('Kesalahan umum saat login', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat login.']);
        }
    }

    /* ========================== LOGOUT ========================== */
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    /* ========================== PRIVATE HELPERS ========================== */
    private function validateRegister(Request $request)
    {
        $messages = [
            // Data akun
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar, silakan gunakan username lain.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

            // Biodata siswa
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal :max karakter.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',

            'tempat_tanggal_lahir.required' => 'Tempat dan tanggal lahir wajib diisi.',
            'tempat_tanggal_lahir.max' => 'Tempat dan tanggal lahir maksimal :max karakter.',

            'agama.required' => 'Agama wajib diisi.',

            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ayah.max' => 'Nama ayah maksimal :max karakter.',

            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'nama_ibu.max' => 'Nama ibu maksimal :max karakter.',

            'alamat.required' => 'Alamat wajib diisi.',

            // Berkas
            'akta_kelahiran.required' => 'File akta kelahiran wajib diunggah.',
            'akta_kelahiran.file' => 'File akta kelahiran tidak valid.',
            'akta_kelahiran.mimes' => 'Akta kelahiran harus berformat jpg, png, atau pdf.',
            'akta_kelahiran.max' => 'Ukuran file akta kelahiran maksimal 2MB.',

            'kartu_keluarga.required' => 'File kartu keluarga wajib diunggah.',
            'kartu_keluarga.file' => 'File kartu keluarga tidak valid.',
            'kartu_keluarga.mimes' => 'Kartu keluarga harus berformat jpg, png, atau pdf.',
            'kartu_keluarga.max' => 'Ukuran file kartu keluarga maksimal 2MB.',

            'pas_foto.required' => 'File pas foto wajib diunggah.',
            'pas_foto.file' => 'File pas foto tidak valid.',
            'pas_foto.mimes' => 'Pas foto harus berformat jpg, png, atau pdf.',
            'pas_foto.max' => 'Ukuran file pas foto maksimal 2MB.',

            'ktp_ortu.required' => 'File KTP orang tua wajib diunggah.',
            'ktp_ortu.file' => 'File KTP orang tua tidak valid.',
            'ktp_ortu.mimes' => 'KTP orang tua harus berformat jpg, png, atau pdf.',
            'ktp_ortu.max' => 'Ukuran file KTP orang tua maksimal 2MB.',
        ];

        $request->validate(
            [
                // Data akun
                'username' => 'required|unique:pengguna,username',
                'email' => 'required|email|unique:pengguna,email',
                'password' => 'required|min:5|confirmed',

                // Biodata siswa
                'nama_lengkap' => 'required|max:50',
                'jenis_kelamin' => 'required',
                'tempat_tanggal_lahir' => 'required|max:100',
                'agama' => 'required',
                'nama_ayah' => 'required|max:50',
                'nama_ibu' => 'required|max:50',
                'alamat' => 'required',

                // Berkas
                'akta_kelahiran' => 'required|file|mimes:jpg,png,pdf|max:2048',
                'kartu_keluarga' => 'required|file|mimes:jpg,png,pdf|max:2048',
                'pas_foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
                'ktp_ortu' => 'required|file|mimes:jpg,png,pdf|max:2048',
            ],
            $messages,
        );
    }

    private function saveBerkas(Request $request, $siswaId, $field, $jenis)
    {
        if (!$request->hasFile($field)) {
            return;
        }

        try {
            $file = $request->file($field);
            $folder = public_path('asset/berkas_siswa');
            $filename = time() . '_' . uniqid() . '_' . $field . '.' . $file->getClientOriginalExtension();

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $file->move($folder, $filename);

            SiswaBerkas::create([
                'siswa_id' => $siswaId,
                'jenis_berkas' => $jenis,
                'file_path' => 'asset/berkas_siswa/' . $filename,
            ]);
        } catch (Exception $e) {
            throw new Exception("Gagal upload berkas {$jenis}");
        }
    }
}
