@extends('layouts.guest.app')
@section('Judul', 'TKIT BINA PRESTASI - Beranda')
@section('content')

    <!-- Hero Section -->
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center text-center text-white"
        style="background: url('{{ asset('asset/img/TK.jpg') }}') center/cover no-repeat;">
        <div>
            <h1 class="display-4 fw-bold text-white">SELAMAT DATANG DI TKIT BINA PRESTASI</h1>
            <a href="{{ route('register') }}" class="btn btn-lg mt-3"
                style="background-color: #3f417e; color: white">PENDAFTARAN SISWA
                BARU</a>
        </div>
    </div>

    <!-- Deskripsi -->
    <section class="py-5 text-center">
        <div class="container">
            <h1 class="mb-4">TKIT BINA PRESTASI</h1>
            <p class="text-justify">
                Taman Kanak-Kanak Islam Terpadu (TKIT) Bina Prestasi berdiri pada tahun 2014 yang berdiri di bawah naungan
                Yayasan Insan Bina Prestasi yang dipimpinan oleh Tuty Munawaroh S.Pd.I. TKIT Bina Prestasi berkomitmen untuk
                memberikan pola pendidikan yang terbaik bagi anak-anak untuk menyelenggarakan pendidikan yang
                berkesinambungan dan ramah anak. Kurikulum TKIT Bina Prestasi disusun dengan mengusung nilai-nilai Islami
                sebagai dasar untuk mengembangkan karakter peserta didik. TKIT Bina Prestasi terbagi dalam kelompok PG (usia
                3 tahun), Kelompok A (usia 4- 5 tahun), dan Kelompok B (usia 5-6 tahun). Proses pembelajaran berlangsung
                selama 5 kali dalam seminggu dengan menggunakan pembelajaran sentra.
            </p>
        </div>
    </section>

    <!-- Galeri (Tetap Menggunakan Owl Carousel) -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="mb-4">GALERI</h1>
            <div class="owl-carousel owl-theme">
                @foreach (['Staff', 'Foto Bersama 1', 'Foto Bersama 2', 'Foto Bersama 3', 'Foto Bersama 4', 'Gambar 1', 'Gambar 2', 'Gambar 3', 'Wisuda 1', 'Wisuda 2', 'Wisuda 3', 'Foto Guru 1', 'Foto Guru 2'] as $img)
                    <div class="item">
                        <img src="{{ asset('asset/img/' . $img . '.jpg') }}" class="w-100 rounded shadow-sm"
                            alt="{{ $img }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-3">
                @php
                    $videos = ['video-1', 'video-2', 'video-3'];
                @endphp

                @foreach ($videos as $video)
                    <div class="col-md-4">
                        <div class="ratio ratio-16x9">
                            <video controls class="w-100 rounded shadow-sm">
                                <source src="{{ asset("asset/video/{$video}.mp4") }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video ini.
                            </video>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- PPDB -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h1 class="mb-4">PPDB ONLINE 2025/2026</h1>
            <div class="row g-3">
                @foreach ([['Uang Pendaftaran', 'Rp200.000'], ['Uang Pangkal', 'Rp600.000'], ['Uang Gedung', 'Rp500.000']] as $item)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h3 class="card-title">{{ $item[0] }}</h3>
                                <p class="text-muted text-decoration-line-through">{{ $item[1] }}</p>
                                <h2 class="text-success">GRATIS</h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-4">FREQUENTLY ASKED QUESTIONS</h1>
            <div class="accordion" id="faqAccordion">
                @foreach ([
            [
                'Bagaimana Cara Daftar ke TKIT Bina Prestasi?',
                '<ul>
                                                                                                                <li>Datang langsung ke Kantor TKIT Bina Prestasi</li>
                                                                                                                <li>Daftar online <a href="' .
            route('register') .
            '">Klik Disini</a></li>
                                                                                                                <li>Info lebih lanjut hubungi admin <a href="http://wa.me/6285765549259">Klik Disini</a></li>
                                                                                                              </ul>',
            ],
            ['Kurikulum yang digunakan di TKIT Bina Prestasi', 'Kami menggunakan Kurikulum Merdeka dengan pembelajaran sentra seni, bahasa, dan imtak.'],
            ['Fasilitas di TKIT Bina Prestasi', '<ul><li>Ruang kantor, guru, kelas sentra, taman bermain, tempat tunggu, kamar mandi, wastafel, keran wudhu.</li><li>Lingkungan nyaman dan aman.</li></ul>'],
            ['Program Kegiatan di TKIT Bina Prestasi', '<ul><li>Cooking class, silat, menggambar, menari, menyanyi.</li><li>Home visit, field trip, manasik haji, pemeriksaan kesehatan, praktek shalat.</li></ul>'],
            [
                'Rincian Biaya TKIT Bina Prestasi',
                '<ul>
                                                                                                                <li>Uang Pendaftaran <b class="float-end">GRATIS</b></li>
                                                                                                                <li>Uang Pangkal <b class="float-end">GRATIS</b></li>
                                                                                                                <li>Buku Pelajaran <b class="float-end">Rp200.000</b></li>
                                                                                                                <li>Seragam 4 set <b class="float-end">Rp800.000</b></li>
                                                                                                                <li>SPP Perbulan <b class="float-end">Rp200.000</b></li>
                                                                                                              </ul>',
            ],
        ] as $key => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $key }}">
                                <strong>{{ $faq[0] }}</strong>
                            </button>
                        </h2>
                        <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">{!! $faq[1] !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Tombol Back to Top -->
    <button class="btn btn-dark position-fixed bottom-0 end-0 m-4 rounded-circle shadow" id="backToTopBtn"
        title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection
