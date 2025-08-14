@extends('layouts.guest.app')
@section('Judul', 'Pendaftaran')
@section('content')
    <div class="container-fluid pt-5 pb-5 bg-light menu">
        <div class="container text-center">
            <h1>PENDAFTARAN</h1>
            <p class="lead">Silakan isi form berikut dengan benar untuk mendaftar di <b>TKIT BINA PRESTASI</b></p>
        </div>

        <div class="container">
            <form class="row" method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 mx-auto">
                    <div class="card shadow-lg p-4">
                        {{-- Biodata Siswa --}}
                        <h5 class="mb-3 fw-bold">BIODATA SISWA</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}"
                                required>
                            <small class="form-text text-muted">Isi sesuai dengan Akta Kelahiran.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" class="form-control"
                                value="{{ old('nama_panggilan') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas" class="form-select" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas }}">TK {{ strtoupper($kelas) }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis
                                    Kelamin
                                </option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-Laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" name="tempat_tanggal_lahir" class="form-control"
                                placeholder="Contoh: Tangerang, 12 Januari 2020" value="{{ old('tempat_tanggal_lahir') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select" required>
                                <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih Agama</option>
                                @foreach (['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $a)
                                    <option value="{{ $a }}" {{ old('agama') == $a ? 'selected' : '' }}>
                                        {{ $a }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Anak ke-</label>
                            <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control"
                                value="{{ old('pekerjaan_ayah') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control"
                                value="{{ old('pekerjaan_ibu') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP/WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890"
                                value="{{ old('no_hp') }}">
                            <small class="form-text text-muted">Gunakan nomor aktif agar mudah dihubungi.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Rumah</label>
                            <textarea name="alamat" class="form-control" rows="3"
                                placeholder="Contoh: Villa Mutiara Pluit Blok F3 No. 43, Periuk, Periuk, Kota Tangerang" required>{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Akun --}}
                        <h5 class="mb-3 fw-bold">AKUN</h5>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                placeholder="Contoh: tkbinaprestasi@gmail.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        {{-- Upload Berkas --}}
                        <h5 class="mt-4 fw-bold">UPLOAD BERKAS</h5>
                        <small class="form-text text-muted mb-2">Format file: JPG, PNG, atau PDF (Maks. 2MB)</small>

                        <div class="mb-3">
                            <label class="form-label">Akta Kelahiran</label>
                            <input type="file" name="akta_kelahiran" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kartu Keluarga</label>
                            <input type="file" name="kartu_keluarga" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pas Foto</label>
                            <input type="file" name="pas_foto" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">KTP Orangtua</label>
                            <input type="file" name="ktp_ortu" class="form-control">
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg w-100"
                                style="background-color: #3f417e; color: white">Daftar
                                Sekarang</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="back-to-top" id="backToTopBtn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </div>
@endsection
