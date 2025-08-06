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

                    {{-- Biodata Siswa --}}
                    <h5 class="mb-3">Biodata Siswa</h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Muhammad Arifin"
                            value="{{ old('nama_lengkap') }}" required>
                        <small class="form-text text-muted">Isi sesuai dengan Akta Kelahiran.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control" placeholder="Contoh: Arif"
                            value="{{ old('nama_panggilan') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin
                            </option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
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
                            <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih agama</option>
                            @foreach (['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama') == $a ? 'selected' : '' }}>
                                    {{ $a }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Anak ke-</label>
                        <input type="number" name="anak_ke" class="form-control" placeholder="Contoh: 1"
                            value="{{ old('anak_ke') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control" placeholder="Contoh: Ahmad Fadli"
                            value="{{ old('nama_ayah') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control" placeholder="Contoh: Siti Aminah"
                            value="{{ old('nama_ibu') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control"
                            placeholder="Contoh: Karyawan Swasta" value="{{ old('pekerjaan_ayah') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control"
                            placeholder="Contoh: Ibu Rumah Tangga" value="{{ old('pekerjaan_ibu') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. HP/WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890"
                            value="{{ old('no_hp') }}">
                        <small class="form-text text-muted">Gunakan nomor aktif agar mudah dihubungi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Rumah</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Raya Bintaro No.12, Tangerang"
                            required>{{ old('alamat') }}</textarea>
                    </div>

                    {{-- Akun --}}
                    <h5 class="mb-3">Akun</h5>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: arifin"
                            value="{{ old('username') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Contoh: arifin@mail.com"
                            value="{{ old('email') }}" required>
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
                    <h5 class="mt-4">Upload Berkas</h5>
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
                        <label class="form-label">KTP Orang Tua</label>
                        <input type="file" name="ktp_ortu" class="form-control">
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Daftar Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="back-to-top" id="backToTopBtn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </div>
@endsection
