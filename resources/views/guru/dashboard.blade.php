@extends('layouts.auth.app')

@section('judul', 'TKIT BINA PRESTASI - Dashboard')

@section('content')
    <div class="container">
        <div class="row">

            {{-- 🔹 Statistik Jumlah Siswa --}}
            <div class="col-md-3 mb-3">
                <x-card title="Jumlah Siswa" icon="fas fa-user-graduate" color="primary">
                    <h3 class="fw-bold text-center">{{ $jumlah_siswa }}</h3>
                </x-card>
            </div>

            {{-- 🔹 Mading Sekolah --}}
            <div class="col-md-12 mb-3">
                <x-card title="Informasi Terbaru" icon="fas fa-bullhorn" color="warning">
                    @forelse($mading as $surat)
                        <div class="mb-3 border-bottom pb-2">
                            <h6 class="fw-bold">{{ $surat->judul }}</h6>
                            <p class="text-muted mb-0">{{ $surat->isi }}</p>
                        </div>
                    @empty
                        <p class="text-center text-muted mb-0">Tidak ada mading saat ini.</p>
                    @endforelse
                </x-card>
            </div>

            {{-- 🔹 Ranking Siswa per Kelas --}}
            <div class="col-md-12 mb-3">
                <x-card title="Ranking Siswa (Top 5)" icon="fas fa-trophy" color="info">

                    @forelse($ranking_per_kelas as $kelasData)
                        @php
                            $kelas = $kelasData['kelas'];
                            $siswaList = $kelasData['ranking'];
                        @endphp

                        <div class="mt-2">
                            <h5 class="text-primary fw-semibold">
                                {{ $kelas->nama_kelas }}
                                <small class="text-muted d-block">
                                    Tingkat: {{ $kelas->tingkat }} |
                                    Tahun Ajaran: {{ $kelas->tahun_ajaran }} |
                                    Guru: {{ $kelas->guru->nama_lengkap }}
                                </small>
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mt-3 mb-4">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Nama Siswa</th>
                                            <th style="width: 20%">Rata-rata Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($siswaList as $siswa)
                                            @php
                                                $avg = $siswa->rata_rata_nilai ?? 0;
                                                $badge =
                                                    $avg >= 75
                                                        ? 'bg-success'
                                                        : ($avg >= 50
                                                            ? 'bg-warning text-dark'
                                                            : 'bg-danger');
                                            @endphp
                                            <tr>
                                                <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                                                <td>{{ $siswa->nama_lengkap }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $badge }} px-3 py-2">
                                                        {{ number_format($avg, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted fst-italic">Tidak ada siswa
                                                    di kelas ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center fst-italic">Belum ada kelas yang diampu.</p>
                    @endforelse

                </x-card>
            </div>

            {{-- 🔹 Aktivitas Harian Siswa --}}
            <div class="col-md-12 mb-3">
                <x-card title="Aktivitas Harian Siswa" icon="fas fa-calendar-day" color="secondary">
                    <x-slot name="action">
                        <a href="{{ route('guru.aktivitas.index') }}" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-cogs"></i> Kelola Aktivitas
                        </a>
                    </x-slot>
                    @forelse($aktivitas_guru as $a)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</strong> -
                            {{ $a->aktivitas }}
                            <small class="text-muted d-block">Untuk: {{ $a->siswa->nama_lengkap }}</small>
                        </div>
                    @empty
                        <p class="text-center text-muted mb-0">Belum ada aktivitas yang Anda catat.</p>
                    @endforelse
                </x-card>
            </div>

            {{-- 🔹 Nilai Siswa --}}
            <div class="col-md-12 mb-3">
                <x-card title="Nilai Siswa" icon="fas fa-chart-line" color="success">
                    <x-slot name="action">
                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-cogs"></i> Kelola Nilai
                        </a>
                    </x-slot>
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nilai_siswa as $n)
                                @php
                                    $badge =
                                        $n->nilai >= 75
                                            ? 'bg-success'
                                            : ($n->nilai >= 50
                                                ? 'bg-warning text-dark'
                                                : 'bg-danger');
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($n->tanggal_input)->format('d M Y') }}</td>
                                    <td>{{ $n->siswa->nama_lengkap }}</td>
                                    <td>{{ $n->mata_pelajaran }}</td>
                                    <td><span class="badge {{ $badge }}">{{ $n->nilai }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada nilai yang Anda input.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </x-card>
            </div>

        </div>
    </div>
@endsection
