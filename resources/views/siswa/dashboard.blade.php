@extends('layouts.auth.app')

@section('judul', 'TKIT BINA PRESTASI - Dashboard')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- 🔹 Informasi Terbaru --}}
                <x-card title="Informasi Terbaru" icon="fas fa-bullhorn" color="info">
                    @forelse($mading as $surat)
                        <div class="border-bottom pb-2 mb-3">
                            <h6 class="fw-bold">{{ $surat->judul }}</h6>
                            <p class="mb-0">{{ $surat->isi }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada informasi terbaru.</p>
                    @endforelse
                </x-card>

                {{-- 🔹 Absensi --}}
                <x-card title="Absensi" icon="fas fa-calendar-check" color="success">
                    @forelse($siswa->absensi as $a)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</strong><br>

                            <span
                                class="badge bg-{{ [
                                    'Hadir' => 'success',
                                    'Izin' => 'info',
                                    'Sakit' => 'warning',
                                    'Alpa' => 'danger',
                                ][$a->status] ?? 'secondary' }}">
                                {{ $a->status }}
                            </span>

                            <div class="mt-1">
                                <small>
                                    <i class="fas fa-user-tie"></i> Guru: {{ $a->guru->nama_lengkap ?? '-' }}<br>
                                    <i class="fas fa-school"></i> Kelas:
                                    {{ 'TK ' . $a->kelas->tingkat . ' - ' . $a->kelas->nama_kelas . ' (' . $a->kelas->tahun_ajaran . ')' }}<br>
                                    <i class="fas fa-sticky-note"></i> Keterangan: {{ $a->keterangan ?? '-' }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada catatan absensi.</p>
                    @endforelse
                </x-card>

                {{-- 🔹 Nilai Akademik --}}
                <x-card title="Nilai Akademik" icon="fas fa-chart-line" color="warning">
                    @forelse($siswa->nilai as $n)
                        @php
                            $badge = match (true) {
                                $n->nilai >= 75 => 'bg-success',
                                $n->nilai >= 50 => 'bg-warning text-dark',
                                default => 'bg-danger',
                            };
                        @endphp

                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                {{-- Mata Pelajaran --}}
                                <strong>{{ $n->mata_pelajaran }}</strong>

                                {{-- Nilai --}}
                                <span class="badge {{ $badge }} px-3 py-2">{{ $n->nilai }}</span>
                            </div>

                            <div class="d-flex justify-content-between text-muted mt-1 small">
                                {{-- Guru --}}
                                <div>{{ $n->guru->nama_lengkap }}</div>

                                {{-- Keterangan --}}
                                <div>{{ $n->keterangan }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada nilai yang tercatat.</p>
                    @endforelse
                </x-card>

                {{-- 🔹 Aktivitas Harian --}}
                <x-card title="Aktivitas Harian" icon="fas fa-calendar-day" color="secondary">
                    @forelse($siswa->aktivitas as $a)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</strong> -
                            {{ $a->kegiatan }}
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada catatan aktivitas.</p>
                    @endforelse
                </x-card>
            </div>
        </div>
    </div>
@endsection
