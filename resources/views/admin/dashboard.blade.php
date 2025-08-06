@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Dashboard')

@section('content')
    <div class="container my-4">
        <div class="row g-3">

            {{-- 🔹 Notifikasi --}}
            <div class="col-12">
                <x-card title="Notifikasi" icon="fas fa-bell" color="secondary">
                    @forelse($notifikasi as $n)
                        <div class="p-2 mb-2 border rounded bg-light">
                            <h6 class="mb-1 fw-bold">{{ $n->data['title'] ?? 'Notifikasi' }}</h6>
                            <p class="mb-1 text-muted">{{ $n->data['message'] ?? '' }}</p>
                            <small class="text-secondary">
                                <i class="fas fa-clock me-1"></i>{{ $n->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @empty
                        <p class="text-center text-muted my-3">Tidak ada notifikasi.</p>
                    @endforelse
                </x-card>
            </div>

            {{-- 🔹 Statistik --}}
            @php
                $stats = [
                    [
                        'title' => 'Jumlah Siswa',
                        'icon' => 'fas fa-user-graduate',
                        'color' => 'primary',
                        'value' => $jumlah_siswa,
                    ],
                    [
                        'title' => 'Jumlah Guru',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'color' => 'success',
                        'value' => $jumlah_guru,
                    ],
                    [
                        'title' => 'Total Mading',
                        'icon' => 'fas fa-bullhorn',
                        'color' => 'warning',
                        'value' => $jumlah_mading,
                    ],
                    [
                        'title' => 'Berkas Siswa',
                        'icon' => 'fas fa-file-alt',
                        'color' => 'danger',
                        'value' => $jumlah_berkas,
                    ],
                    [
                        'title' => 'Jumlah Kelas',
                        'icon' => 'fas fa-chalkboard',
                        'color' => 'secondary',
                        'value' => $jumlah_kelas,
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-md-3 col-6">
                    <x-card title="{{ $stat['title'] }}" icon="{{ $stat['icon'] }}" color="{{ $stat['color'] }}">
                        <h2 class="fw-bold text-center mb-0">{{ $stat['value'] }}</h2>
                    </x-card>
                </div>
            @endforeach

            {{-- 🔹 Mading --}}
            <div class="col-12">
                <x-card title="📢 Surat Pemberitahuan / Mading" icon="fas fa-bullhorn" color="warning">
                    <x-slot name="action">
                        <a href="{{ route('admin.mading.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-cogs"></i> Kelola
                        </a>
                    </x-slot>

                    @forelse($mading as $surat)
                        <div class="p-2 mb-2 border-bottom">
                            <h6 class="fw-bold mb-1">{{ $surat->judul }}</h6>
                            <p class="text-muted mb-1">{{ Str::limit($surat->isi, 120) }}</p>
                            <small class="text-secondary">✍️ {{ $surat->admin->nama_lengkap ?? 'Admin' }}</small>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada surat pemberitahuan.</p>
                    @endforelse
                </x-card>
            </div>

            {{-- 🔹 Ranking Siswa Berdasarkan Kelas --}}
            <div class="col-12">
                <x-card title="🏆 Ranking Siswa Berdasarkan Kelas (Top 5 per Kelas)" icon="fas fa-trophy" color="info">
                    @forelse($ranking_per_kelas as $kelasId => $siswaList)
                        @php
                            $kelas = $siswaList->first()->kelas;
                        @endphp
                        <h5 class="mt-3 mb-2 text-success fw-bold">
                            {{ $kelas->nama_kelas }} (Tingkat: {{ $kelas->tingkat }}, Tahun Ajaran:
                            {{ $kelas->tahun_ajaran }}, Guru: {{ $kelas->guru->nama_lengkap }})
                        </h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Rata-rata Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswaList as $s)
                                        <tr>
                                            <td class="fw-bold">{{ $loop->iteration }}</td>
                                            <td>{{ $s->nama_lengkap }}</td>
                                            <td>
                                                @php
                                                    $avg = $s->rata_rata_nilai ?? 0;
                                                    $badge =
                                                        $avg >= 75
                                                            ? 'bg-success'
                                                            : ($avg >= 50
                                                                ? 'bg-warning text-dark'
                                                                : 'bg-danger');
                                                @endphp
                                                <span
                                                    class="badge {{ $badge }}">{{ number_format($avg, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada data ranking siswa.</p>
                    @endforelse
                </x-card>
            </div>

        </div>
    </div>
@endsection
