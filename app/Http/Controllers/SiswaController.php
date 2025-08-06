<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Siswa;
use App\Models\SiswaBerkas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('pengguna_id')) {
                return redirect('/login');
            }
            return $next($request);
        });
    }

    /** ========================== 🟢 BIODATA SISWA ========================== */
    public function biodata()
    {
        if (!session('pengguna_id')) {
            return redirect()
                ->route('login')
                ->withErrors(['message' => 'Anda harus login terlebih dahulu.']);
        }

        $pengguna_id = session('pengguna_id');
        $biodata = Siswa::where('pengguna_id', $pengguna_id)->first();

        return view('siswa.biodata-diri', compact('biodata'));
    }

    public function biodatasave(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:50',
            'nickName' => 'required|string|max:10',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'birthPlaceDate' => 'required|string|max:50',
            'agama' => 'required|string|in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu',
            'anakKe' => 'required|integer|min:1|max:11',
            'parentNameAyah' => 'required|string|max:50',
            'parentNameIbu' => 'required|string|max:50',
            'profesiayah' => 'required|string|max:30',
            'profesiibu' => 'required|string|max:30',
            'telayah' => 'required|numeric|digits_between:10,15',
            'address' => 'required|string|max:255',
            'berkas.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $pengguna_id = session('pengguna_id');

            // Simpan / update biodata siswa
            $siswa = Siswa::updateOrCreate(
                ['pengguna_id' => $pengguna_id],
                [
                    'nama_lengkap' => $request->fullName,
                    'nama_panggilan' => $request->nickName,
                    'jenis_kelamin' => $request->gender,
                    'tempat_tanggal_lahir' => $request->birthPlaceDate,
                    'agama' => $request->agama,
                    'anak_ke' => $request->anakKe,
                    'nama_ayah' => $request->parentNameAyah,
                    'nama_ibu' => $request->parentNameIbu,
                    'pekerjaan_ayah' => $request->profesiayah,
                    'pekerjaan_ibu' => $request->profesiibu,
                    'no_hp' => $request->telayah,
                    'alamat' => $request->address,
                ],
            );

            // ✅ Proses upload berkas penunjang
            if ($request->hasFile('berkas')) {
                foreach ($request->file('berkas') as $jenis => $file) {
                    if ($file) {
                        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('asset/berkas_siswa');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }

                        $file->move($destinationPath, $filename);
                        $filePath = 'asset/berkas_siswa/' . $filename;

                        SiswaBerkas::create([
                            'id' => Str::uuid(),
                            'siswa_id' => $siswa->id,
                            'jenis_berkas' => ucfirst(str_replace('_', ' ', $jenis)),
                            'file_path' => $filePath,
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Biodata dan berkas berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan biodata: ' . $e->getMessage());
        }
    }

    /** ========================== 🟢 UPDATE PROFIL ========================== */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $pengguna = Pengguna::findOrFail(Session::get('pengguna_id'));

            $pengguna->nama_lengkap = $request->nama_lengkap;
            $pengguna->email = $request->email;

            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
                $pengguna->save();

                Session::flush();
                return redirect('/login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
            }

            $pengguna->save();
            return redirect()->route('auth.profil')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui profil. Silakan coba lagi.']);
        }
    }

    /** ========================== 🟢 JADWAL AKADEMIK ========================== */
    public function showJadwal()
    {
        return view('siswa.jadwal-akademik');
    }

    /** ========================== 🟢 PEMBAYARAN (SISWA) ========================== */
    public function dataPembayaran()
    {
        $siswa = $this->getLoggedInSiswa();
        if (!$siswa) {
            return abort(403, 'Data siswa tidak ditemukan.');
        }

        $pembayaran = Pembayaran::where('siswa_id', $siswa->id)->get();
        return view('siswa.pembayaran', compact('pembayaran', 'siswa'));
    }

    public function tambahPembayaran(Request $request)
    {
        try {
            $siswa = $this->getLoggedInSiswa();
            if (!$siswa) {
                return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan.'], 403);
            }

            $data = $request->validate([
                'jenis_pembayaran' => 'required|in:pendaftaran,seragam,spp,lainnya',
                'jumlah' => 'required|numeric|min:0',
                'metode' => 'required|in:transfer,tunai,qris',
                'tanggal_pembayaran' => 'required|date',
                'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data['siswa_id'] = $siswa->id;

            if ($request->hasFile('bukti_pembayaran')) {
                $data['bukti_pembayaran'] = $this->uploadBukti($request);
            }

            Pembayaran::create($data);
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil ditambahkan. Menunggu verifikasi admin.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updatePembayaran(Request $request, $id)
    {
        $siswa = $this->getLoggedInSiswa();
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan.'], 403);
        }

        $pembayaran = Pembayaran::where('siswa_id', $siswa->id)->where('status', 'pending')->findOrFail($id);

        $data = $request->validate([
            'jenis_pembayaran' => 'required|in:pendaftaran,seragam,spp,lainnya',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:transfer,tunai,qris',
            'tanggal_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $this->hapusBukti($pembayaran->bukti_pembayaran);
            $data['bukti_pembayaran'] = $this->uploadBukti($request);
        }

        try {
            $pembayaran->update($data);
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deletePembayaran($id)
    {
        $siswa = $this->getLoggedInSiswa();
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan.'], 403);
        }

        $pembayaran = Pembayaran::where('siswa_id', $siswa->id)->where('status', 'pending')->findOrFail($id);

        try {
            $this->hapusBukti($pembayaran->bukti_pembayaran);
            $pembayaran->delete();

            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** ========================== 🛠️ HELPER METHOD ========================== */
    private function uploadBukti($request)
    {
        if ($request->hasFile('bukti_pembayaran')) {
            $filename = time() . '_' . $request->file('bukti_pembayaran')->getClientOriginalName();
            $request->file('bukti_pembayaran')->move(public_path('asset/img/bukti_pembayaran'), $filename);
            return $filename;
        }
        return null;
    }

    private function hapusBukti($filename)
    {
        $path = public_path('asset/img/bukti_pembayaran/' . $filename);
        if ($filename && file_exists($path)) {
            unlink($path);
        }
    }

    private function getLoggedInSiswa()
    {
        $pengguna = Pengguna::with('siswa')->find(session('pengguna_id'));
        return $pengguna ? $pengguna->siswa : null;
    }
}
