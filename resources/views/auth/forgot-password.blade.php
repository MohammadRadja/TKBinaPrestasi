@extends('layouts.guest.app')
@section('Judul', 'TKIT BINA PRESTASI - Forgot Password')
@section('content')
    <div class="container-fluid pt-5 pb-5 bg-light menu">
        <div class="container text-center">
            <h1 class="display-2 mb-4">RESET PASSWORD</h1>
        </div>
        <div class="container">
            <form method="POST" action="{{ route('password.reset') }}" class="row g-3">
                @csrf
                <div class="col-md-6 mx-auto col-10">
                    <div class="card shadow-lg p-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <div class="mb-3 text-center">
                            <p>Sudah Punya Akun? <a href="/login" class="text-decoration-none">Login Disini</a></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection