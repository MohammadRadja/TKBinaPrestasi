@extends('layouts.guest.app')
@section('Judul', 'Login')
@section('content')
    <section class="container-fluid pt-5 pb-5 bg-light menu">
        <div class="container text-center">
            <h1 class="display-2 mb-4">LOGIN</h1>
        </div>

        <div class="container">
            <form method="POST" action="{{ route('login.post') }}" class="row g-3">
                @csrf
                <div class="col-md-6 mx-auto col-10">
                    <div class="card shadow-lg p-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 text-center">
                            <p>Lupa Password? <a href="{{ route('password.request') }}" class="text-decoration-none">Reset
                                    Password</a></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
