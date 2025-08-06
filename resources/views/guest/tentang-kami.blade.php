@extends('layouts.guest.app')

@section('Judul', 'TKIT BINA PRESTASI - Tentang Kami')

@section('content')
    <!-- Sambutan -->
    <section class="container my-5 py-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-justify">
                <h1 class="card-title text-center mb-4">SAMBUTAN KETUA YAYASAN</h1>
                <div class="row">
                    <div class="col-lg-8">
                        <p>Assalamu'alaikum warahmatullahi wabarakatuh</p>
                        <p>Segala puji atas kehadirat Allah SWT... </p>
                        <p>Ucapan terima kasih kami sampaikan kepada para orang tua siswa... </p>
                        <p>Yayasan Insan Bina Prestasi terus melakukan inovasi... </p>
                        <p>Akhirnya hanya kepada Allah SWT kita berharap... </p>
                        <p>Wassalamu'alaikum warohmatullahi wabarokatuh</p>
                        <p class="fw-bold text-end mb-0">Tuty Munawaroh, S.Pd.I.</p>
                        <p class="text-end">Ketua Yayasan Insan Bina Prestasi</p>
                    </div>
                    <div class="col-lg-4 text-center">
                        <img src="{{ asset('asset/img/ketua-yayasan.jpg') }}" alt="Ketua Yayasan"
                            class="img-fluid rounded shadow mb-3" style="max-width:300px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Tujuan -->
    <section class="container my-5 py-5">
        <div class="row text-center">
            <div class="col-12 mb-4">
                <h1>VISI</h1>
                <p class="lead">Mempersiapkan anak yang cerdas, mandiri, cinta kepada Allah SWT dan Rasulnya, serta
                    berakhlakul karimah</p>
            </div>
            <div class="col-md-6 mb-4">
                <h1>MISI</h1>
                <ul class="list-unstyled text-start">
                    <li>✔ Menghasilkan lulusan yang taat kepada Allah SWT dan Rasulnya</li>
                    <li>✔ Menghasilkan anak yang mempunyai dasar-dasar IPTEK & IMPTAQ</li>
                    <li>✔ Melatih anak dalam menghafal surat-surat pendek Al-Qur'an</li>
                    <li>✔ Membekali anak didik dengan kemampuan sesuai karakteristik usia dini</li>
                    <li>✔ Menanamkan nilai-nilai keagamaan dan ketaqwaan</li>
                    <li>✔ Memberdayakan potensi kecerdasan anak</li>
                    <li>✔ Membekali anak dengan budi pekerti luhur</li>
                    <li>✔ Mempersiapkan anak memasuki jenjang pendidikan dasar</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h1>TUJUAN</h1>
                <ul class="list-unstyled text-start">
                    <li>✔ Membantu pemerintah dalam meningkatkan kesadaran PAUD</li>
                    <li>✔ Menyediakan sarana belajar sambil bermain</li>
                    <li>✔ Meningkatkan layanan pendidikan anak usia dini</li>
                    <li>✔ Membina lingkungan pembelajaran yang kondusif</li>
                    <li>✔ Membina kultur lembaga PAUD yang profesional</li>
                    <li>✔ Meningkatkan sarana prasarana pembelajaran</li>
                    <li>✔ Membina kerjasama dengan stakeholder terkait</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Sejarah Singkat -->
    <section class="container my-5 py-5 bg-light">
        <div class="container">
            <h1 class="text-center mb-4">SEJARAH SINGKAT</h1>
            <p>Pendidikan Anak Usia Dini (PAUD) / Taman Kanak-kanak adalah suatu lembaga pembinaan... </p>
            <p>Pada tahun 2013-2014 kami mengawali aktivitas pembinaan dengan membuka lembaga pengajaran...</p>
            <p>Dengan bernaung di bawah Yayasan Insan Bina Prestasi... </p>
        </div>
    </section>

    <!-- Guru Kami -->
    <section class="container my-5 py-5">
        <h1 class="text-center mb-4">GURU KAMI</h1>
        <div class="row gy-4">
            @php
                $gurus = [
                    ['nama' => 'Ramli, S.Pd.', 'img' => 'ramliprofile.jpg'],
                    ['nama' => 'Rifda Azkia Syahida, S.Pd.D', 'img' => 'rifdaprofile.jpg'],
                    ['nama' => 'Hasani', 'img' => 'hasaniprofile.jpg'],
                    ['nama' => 'Syarifatimah Zahroh, S.Pd', 'img' => 'zahrohprofile.jpg'],
                ];
            @endphp
            @foreach ($gurus as $guru)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <img src="{{ asset('asset/img/guru/' . $guru['img']) }}" class="card-img-top"
                            alt="{{ $guru['nama'] }}">
                        <div class="card-body">
                            <p class="card-text text-primary fw-bold">{{ $guru['nama'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Struktur Organisasi -->
    <section class="container my-5 py-5">
        <h1 class="mb-4 text-center">STRUKTUR ORGANISASI</h1>
        <img src="{{ asset('asset/img/struktur-organisasi.jpg') }}" class="img-fluid rounded shadow"
            alt="Struktur Organisasi">
    </section>

    <!-- Tombol Back to Top -->
    <button class="btn btn-dark position-fixed bottom-0 end-0 m-4 rounded-circle shadow" id="backToTopBtn"
        title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection
