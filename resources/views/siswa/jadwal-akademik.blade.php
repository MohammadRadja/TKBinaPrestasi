@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Jadwal')
@section('content')
    <div class="container-fluid pb-5 bg-light">
        <h3 class="text-center mb-4">Jadwal Sekolah</h3>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Kegiatan Harian</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Hari</th>
                                <th scope="col">Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Senin</td>
                                <td>Upacara, Kognitif</td>
                            </tr>
                            <tr>
                                <td class="text-center">Selasa</td>
                                <td>Shalat Dhuha, Hafalan Hadits, Bahasa Arab, Kognitif</td>
                            </tr>
                            <tr>
                                <td class="text-center">Rabu</td>
                                <td>English Day, Hafalan Doa-Doa Harian, Kognitif, Bahasa Indonesia</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis</td>
                                <td>Olahraga, Cooking Class/Pencak Silat/Melukis/Menari, Menggosok Gigi</td>
                            </tr>
                            <tr>
                                <td class="text-center">Jumat</td>
                                <td>Shalat Fardhu, Hafalan Surat-Surat Pendek, Hijaiyah</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Detail Kegiatan Harian</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Pukul</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col" style="width: 30%;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">07:30-08:00</td>
                                <td>Mengaji</td>
                                <td>PG, TK A, TK B</td>
                            </tr>
                            <tr>
                                <td class="text-center">08:00-08:15</td>
                                <td>Berbaris</td>
                                <td>PG, TK A, TK B</td>
                            </tr>
                            <tr>
                                <td class="text-center">08:15-09:00</td>
                                <td>Pembukaan Shalat Dhuha/Shalat Fardhu dan Hafalan Hadist/Doa-Doa Harian/Surat-Surat Pendek</td>
                                <td>PG, TK A, TK B</td>
                            </tr>
                            <tr>
                                <td class="text-center">09:00-09:30</td>
                                <td>Kognitif/Bahasa</td>
                                <td>PG, TK A, TK B</td>
                            </tr>
                            <tr>
                                <td class="text-center">09:30-09:45</td>
                                <td>Istirahat</td>
                                <td>PG, TK A, TK B</td>
                            </tr>
                            <tr>
                                <td class="text-center">09:45-10:00</td>
                                <td>Recalling, Refleksi, dan Pulang</td>
                                <td>PG, TK A</td>
                            </tr>
                            <tr>
                                <td class="text-center">10:00-10:30</td>
                                <td>Membaca dan Dikte</td>
                                <td>TK B</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Ekstrakurikuler</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Hari</th>
                                <th scope="col">Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Kamis Minggu ke-1</td>
                                <td  class="text-center">Cooking Class</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis Minggu ke-2</td>
                                <td class="text-center">Pencak Silat</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis Minggu ke-3</td>
                                <td class="text-center">Melukis dan Home Visit</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis Minggu ke-4</td>
                                <td class="text-center">Menari</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Menu Cooking Class</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Hari</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col" style="width: 30%;">Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Kamis</td>
                                <td class="text-center">8 Agustus 2024</td>
                                <td class="text-center">Spaghetti</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis</td>
                                <td class="text-center">5 September 2024</td>
                                <td class="text-center">Bubur Kacang Hijau</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis</td>
                                <td class="text-center">3 Oktober 2024</td>
                                <td class="text-center">Sempol Ayam</td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis</td>
                                <td class="text-center">7 November 2024</td>
                                <td class="text-center">Es Kopyor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Menu Sehat POMG</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Bulan</th>
                                <th scope="col">Hari dan Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Agustus</td>
                                <td class="text-center">Jumat, 16 Agustus 2024</td>
                            </tr>
                            <tr>
                                <td class="text-center">September</td>
                                <td class="text-center">Kamis, 12 September 2024</td>
                            </tr>
                            <tr>
                                <td class="text-center">Oktober</td>
                                <td class="text-center">Kamis, 31 Oktober 2024</td>
                            </tr>
                            <tr>
                                <td class="text-center">November</td>
                                <td class="text-center">Kamis, 13 November 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="font-weight-bold">Kegiatan Semester</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col" style="width: 25%;">Tanggal</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col" style="width: 30%;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">Selasa, 23 Juli 2024</td>
                                <td>Memperingati Hari Anak: Kegiatan Mendongeng (Menghadirkan Pendongeng)</td>
                                <td class="text-center">Kegiatan Gabungan dengan TK Al-Amin</td>
                            </tr>
                            <tr>
                                <td class="text-center">Jumat, 16 Agustus 2024</td>
                                <td>Lomba Memperingati Hari Kemerdekaan Indonesia</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Senin, 2 September 2024</td>
                                <td>Memperingati Hari Polisi: Filedtrip ke Polsek Jatiuwung</td>
                                <td class="text-center">Kegiatan Gabungan dengan TK Al-Amin</td>
                            </tr>
                            <tr>
                                <td class="text-center">Selasa, 24 September 2024</td>
                                <td>Memperingati Hari Tani: Kegiatan Menanam Tanaman Herbal</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Minggu, 15 September 2024</td>
                                <td>Kegiatan Manasik Haji</td>
                                <td class="text-center">Wajib Untuk Kelas B</td>
                            </tr>
                            <tr>
                                <td class="text-center">Rabu, 2 Oktober 2024</td>
                                <td>Memperingati Hari Batik Nasional: Memakai Baju Batik dan Membuat Batik dengan Menggunakan Teknik Eco Print</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Kamis, 10 Oktober 2024</td>
                                <td>Renang Ke Fun Park</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Sabtu, 9 November 2024</td>
                                <td>Memperingati Hari Ayah: Kegiatan 1 Hari Bersama Ayah (Melukis Anak dan melengkapi lukisan)</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Senin, 18 November 2024</td>
                                <td>Evaluasi Semester 1</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Senin, 25 November 2024</td>
                                <td>Memperingati Hari Guru: Membuat Kartu Ucapan untuk Guru dan Photo Booth</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Jumat, 13 Desember 2024</td>
                                <td>Pembagian Rapot Semester 1</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Minggu, 15 Desember 2024</td>
                                <td>Fieldtrip Jawara</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td class="text-center">Sabtu, 14 Desember 2024</td>
                                <td>Libur Semester Ganjil</td>
                                <td> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .card {
            border-radius: 10px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .font-weight-bold {
            font-weight: bold !important;
        }
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        .table-dark {
            background-color: #343a40;
            color: #fff;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection