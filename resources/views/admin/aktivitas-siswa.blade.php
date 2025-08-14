@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Aktivitas Harian Siswa')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white ms-5">Daftar Aktivitas Harian</h4>
                <div class="d-flex gap-2">
                    {{-- Sorting --}}
                    <select class="form-select form-select-sm" data-sort data-target="#aktivitasTableBody">
                        <option value="default">Sort by</option>
                        <option value="asc">A-Z</option>
                        <option value="desc">Z-A</option>
                    </select>

                    {{-- Tambah Aktivitas --}}
                    <button class="btn bg-light text-muted text-nowrap" data-crud="add" data-method="POST"
                        data-title="Tambah Aktivitas" data-url="{{ route('admin.aktivitas.store') }}"
                        data-fields='{
                            "guru_id": {"label": "Guru", "type": "select", "placeholder": "Pilih guru", "options": @json($guruList), "hint":"Pilih guru yang mengawasi."},
                            "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList), "hint":"Pilih siswa yang melakukan aktivitas."},
                            "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                            "tanggal": {"label": "Tanggal", "type":"date", "placeholder":"Pilih tanggal aktivitas", "hint":"Tanggal aktivitas berlangsung."},
                            "aktivitas": {"label": "Aktivitas", "placeholder":"Masukkan aktivitas siswa", "hint":"Deskripsikan aktivitas harian siswa."},
                            "catatan": {"label": "Catatan", "type":"textarea", "placeholder":"Tambahkan catatan (opsional)", "hint":"Tambahkan catatan tambahan jika perlu."},
                            "foto_aktivitas": {"label": "Foto Aktivitas", "type":"file", "placeholder":"Upload foto aktivitas", "hint":"Opsional, upload dokumentasi foto."}
                        }'>
                        <i class="fas fa-plus me-1"></i> Tambah Aktivitas
                    </button>
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
                                <th>Aktivitas</th>
                                <th>Catatan</th>
                                <th>Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="aktivitasTableBody">
                            @forelse ($aktivitas as $item)
                                <tr class="text-center">
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                                    <td>{{ 'TK ' . $item->siswa->kelas->tingkat }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $item->aktivitas }}</td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                    <td>
                                        @if ($item->foto_aktivitas)
                                            <img src="{{ asset('img/aktivitas/' . $item->foto_aktivitas) }}"
                                                alt="foto aktivitas" width="60" class="rounded">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Aktivitas --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Aktivitas"
                                                data-url="{{ route('admin.aktivitas.update', $item->id) }}"
                                                data-fields='{
                                                    "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList), "hint":"Pilih siswa yang melakukan aktivitas."},
                                                    "guru_id": {"label": "Guru", "type": "select", "placeholder": "Pilih guru", "options": @json($guruList), "hint":"Pilih guru yang mengawasi."},
                                                    "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                                                    "tanggal": {"label": "Tanggal", "type":"date", "placeholder":"Pilih tanggal aktivitas", "hint":"Tanggal aktivitas berlangsung."},
                                                    "aktivitas": {"label": "Aktivitas", "placeholder":"Masukkan aktivitas siswa", "hint":"Deskripsikan aktivitas harian siswa."},
                                                    "catatan": {"label": "Catatan", "type":"textarea", "placeholder":"Tambahkan catatan (opsional)", "hint":"Tambahkan catatan tambahan jika perlu."},
                                                    "foto_aktivitas": {"label": "Foto Aktivitas", "type":"file", "placeholder":"Upload foto aktivitas", "hint":"Opsional, upload dokumentasi foto."}
                                                }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Aktivitas --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Aktivitas"
                                                data-url="{{ route('admin.aktivitas.delete', $item->id) }}"
                                                data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
