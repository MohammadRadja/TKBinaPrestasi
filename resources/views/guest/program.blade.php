@extends('layouts.guest.app')
@section('Judul', 'TKIT BINA PRESTASI - Program')
@section('content')
    <section class="container my-5 py-5">
        <h1 class="text-center mb-5">EKSTRAKURIKULER DAN PROGRAM</h1>
        <div class="row g-4">
            @php
                $programs = [
                    [
                        'icon' => 'fas fa-fist-raised',
                        'title' => 'Silat',
                        'desc' => 'Mendorong anak-anak untuk bergerak aktif dan meningkatkan kesehatan fisik mereka.',
                    ],
                    [
                        'icon' => 'fas fa-paint-brush',
                        'title' => 'Menggambar',
                        'desc' => 'Mengembangkan kreativitas anak-anak melalui kegiatan melukis dan menggambar.',
                    ],
                    [
                        'icon' => 'fas fa-music',
                        'title' => 'Menyanyi',
                        'desc' =>
                            'Mengenalkan anak-anak pada dunia musik melalui menyanyi dan bermain alat musik sederhana.',
                    ],
                    [
                        'icon' => 'fas fa-desktop',
                        'title' => 'Komputer',
                        'desc' => 'Membantu anak-anak dalam belajar teknologi komputer dasar.',
                    ],
                    [
                        'icon' => 'fas fa-quran',
                        'title' => 'Tahfidz',
                        'desc' => 'Menghafal Al-Quran untuk meningkatkan pemahaman dan hafalan anak-anak.',
                    ],
                    [
                        'icon' => 'fas fa-kaaba',
                        'title' => 'Manasik Haji',
                        'desc' => 'Mengajarkan anak-anak tentang ibadah Haji melalui praktek manasik.',
                    ],
                ];
            @endphp

            @foreach ($programs as $program)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 text-center p-3">
                        <i class="{{ $program['icon'] }} fa-4x text-primary mb-3"></i>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $program['title'] }}</h5>
                            <p class="card-text">{{ $program['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- FASILITAS -->
    <section class="container my-5 py-5">
        <h1 class="text-center mb-5">FASILITAS</h1>
        <div class="row g-4">
            @php
                $fasilitas = [
                    ['img' => 'ruangan/ruang-kelas-a.jpg', 'title' => 'Ruang Kelas A'],
                    ['img' => 'ruangan/ruang-kelas-b.jpg', 'title' => 'Ruang Kelas B'],
                    ['img' => 'ruangan/ruang-kantor.jpg', 'title' => 'Ruang Kantor'],
                    ['img' => 'ruangan/taman-bermain.jpg', 'title' => 'Taman Bermain'],
                    ['img' => 'ruangan/toilet.jpg', 'title' => 'Toilet'],
                    ['img' => 'ruangan/tempat-menunggu.jpg', 'title' => 'Tempat Menunggu'],
                    ['img' => 'ruangan/ruang-guru.jpg', 'title' => 'Ruang Guru'],
                    ['img' => 'ruangan/rak-sepatu.jpg', 'title' => 'Rak Sepatu'],
                    ['img' => 'ruangan/perpustakaan.jpg', 'title' => 'Perpustakaan'],
                ];
            @endphp

            @foreach ($fasilitas as $f)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden" style="height:200px;">
                            <img src="{{ asset('asset/img/' . $f['img']) }}" class="img-fluid w-100 h-100"
                                style="object-fit:cover;" alt="{{ $f['title'] }}">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $f['title'] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Tombol Back to Top -->
    <button class="btn btn-dark position-fixed bottom-0 end-0 m-4 rounded-circle shadow" id="backToTopBtn"
        title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection
