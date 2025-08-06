@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Profil Pengguna')
@section('content')
    <h1 class="h3 mb-3">Profil</h1>
    <div>
        <form action="{{ route('siswa.profil.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    value="{{ $pengguna->nama_lengkap }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $pengguna->email }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (opsional)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
@endsection