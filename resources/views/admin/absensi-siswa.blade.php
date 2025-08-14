@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Absensi Siswa')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white ms-5">Daftar Absensi Siswa</h4>
                <div class="d-flex gap-2">
                    {{-- Sorting --}}
                    <select class="form-select form-select-sm" data-sort data-target="#absensiTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">A-Z</option>
                        <option value="nama_desc">Z-A</option>
                    </select>

                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Guru</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody">
                            @forelse ($absensi as $item)
                                <tr class="text-center">
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                                    <td>{{ 'TK ' . $item->kelas->tingkat . ' - ' . $item->kelas->nama_kelas . ' (' . $item->kelas->tahun_ajaran . ')' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $badge =
                                                [
                                                    'Hadir' => 'success',
                                                    'Izin' => 'info',
                                                    'Sakit' => 'warning',
                                                    'Alpa' => 'danger',
                                                ][$item->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ $item->status }}</span>
                                    </td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
