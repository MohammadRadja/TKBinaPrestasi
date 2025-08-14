@extends('layouts.guest.app')
@section('Judul', 'TKIT BINA PRESTASI - Kontak')

@section('content')
    <section class="container my-5 py-5">
        <h1 class="text-center mb-5">HUBUNGI KAMI</h1>

        <div class="row g-4 align-items-stretch">
            <!-- Info Kontak -->
            <div class="col-md-6 d-flex">
                <div class="p-4 shadow-sm rounded bg-light border-start border-4 border-primary w-100">
                    <h4 class="mb-4 fw-bold text-dark">Informasi Kontak</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope text-primary fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">Email:</div>
                                <a href="mailto:tkitbinaprestasi@gmail.com" class="text-muted text-decoration-none">
                                    tkitbinaprestasi@gmail.com
                                </a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="fab fa-whatsapp text-success fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">WhatsApp:</div>
                                <a href="http://wa.me/6285765549259" class="text-muted text-decoration-none">
                                    +62 857-6554-9259
                                </a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="fab fa-facebook-f text-primary fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">Facebook:</div>
                                <a href="https://www.facebook.com/share/nm7a3SsewkULnfoX/?mibextid=qi2Omg"
                                    class="text-muted text-decoration-none">Bina Prestasi</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="fab fa-instagram text-danger fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">Instagram:</div>
                                <a href="https://www.instagram.com/kelasbinaprestasi?igsh=b3M3NXN4MHRha3l4"
                                    class="text-muted text-decoration-none">@kelasbinaprestasi</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="fab fa-youtube text-danger fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">YouTube:</div>
                                <a href="https://youtube.com/@tutymunawaroh7767?si=rkrmZ1Du5fIcoeOj"
                                    class="text-muted text-decoration-none">Tuty Munawaroh</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-danger fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">Alamat:</div>
                                <a href="https://maps.app.goo.gl/n2S7fMC76V5HtWrY6"
                                    class="text-muted text-decoration-none">Villa Mutiara Pluit Blok F3 No. 43, RT 007, RW
                                    009,
                                    Kel. Periuk, Kec. Periuk, Kota Tangerang, Banten 15131</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="col-md-6 d-flex">
                <div class="shadow rounded overflow-hidden w-100">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126916.86337892224!2d106.45518198216801!3d-6.243692790247523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff4420ebe04f%3A0x61aa392b92b6c047!2sTK%20BINA%20PRESTASI%20(ISLAM%20TERPADU)!5e0!3m2!1sid!2sid!4v1720557584165!5m2!1sid!2sid"
                        class="w-100 h-100" style="min-height: 100%; height: 100%;" allowfullscreen loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5 bg-light">
        <div class="container">
            <h1 class="text-center fw-bold mb-4 text-dark">FREQUENTLY ASKED QUESTIONS</h1>
            <div class="accordion shadow rounded" id="faqAccordion">
                @foreach ([
            ['Bagaimana Cara Daftar ke TKIT Bina Prestasi?', '<ul><li>Datang langsung ke Kantor TKIT Bina Prestasi</li><li>Daftar online <a href="' . route('register.post') . '">Klik Disini</a></li><li>Info lebih lanjut hubungi admin <a href="http://wa.me/6285765549259">Klik Disini</a></li></ul>'],
            ['Kurikulum yang digunakan di TKIT Bina Prestasi', 'Kami menggunakan Kurikulum Merdeka dengan pembelajaran sentra seni, bahasa, dan imtak.'],
            ['Fasilitas di TKIT Bina Prestasi', '<ul><li>Ruang kantor, guru, kelas sentra, taman bermain, tempat tunggu, kamar mandi, wastafel, keran wudhu.</li><li>Lingkungan nyaman dan aman.</li></ul>'],
            ['Program Kegiatan di TKIT Bina Prestasi', '<ul><li>Cooking class, silat, menggambar, menari, menyanyi.</li><li>Home visit, field trip, manasik haji, pemeriksaan kesehatan, praktek shalat.</li></ul>'],
            ['Rincian Biaya TKIT Bina Prestasi', '<ul><li>Uang Pendaftaran <b class="float-end">GRATIS</b></li><li>Uang Pangkal <b class="float-end">GRATIS</b></li><li>Buku Pelajaran <b class="float-end">Rp200.000</b></li><li>Seragam 4 set <b class="float-end">Rp800.000</b></li><li>SPP Perbulan <b class="float-end">Rp200.000</b></li></ul>'],
        ] as $key => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $key }}">
                                {{ $faq[0] }}
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
