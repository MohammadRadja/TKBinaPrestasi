@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Absensi Siswa')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Daftar Absensi Siswa</h4>
                <div class="d-flex gap-2">
                    {{-- Sorting --}}
                    <select class="form-select form-select-sm" data-sort data-target="#absensiTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">A-Z</option>
                        <option value="nama_desc">Z-A</option>
                    </select>

                    {{-- Tambah Absensi --}}
                    <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Absensi"
                        data-url="{{ route('guru.absensi.store') }}"
                        data-fields='{
                        "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList), "hint":"Pilih siswa yang absen."},
                        "kelas_id": {"label": "Kelas", "type": "select", "placeholder": "Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                        "tanggal": {"label": "Tanggal", "type":"date", "placeholder":"Pilih tanggal absensi", "hint":"Tanggal absensi dicatat."},
                        "status": {"label": "Status", "type": "select", "placeholder":"Pilih status", "options": {"Hadir":"Hadir","Izin":"Izin","Sakit":"Sakit","Alpa":"Alpa"}, "hint":"Pilih status kehadiran siswa."},
                        "keterangan": {"label": "Keterangan", "type": "textarea", "placeholder":"Tambahkan keterangan", "hint":"Opsional, catatan tambahan."}
                    }'>
                        <i class="fas fa-plus me-1"></i> Tambah Absensi
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Guru</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody">
                            @forelse ($absensi as $item)
                                <tr>
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
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Absensi --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Absensi"
                                                data-url="{{ route('guru.absensi.update', $item->id) }}"
                                                data-fields='{
                                                "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList)},
                                                "kelas_id": {"label": "Kelas", "type": "select", "placeholder": "Pilih kelas", "options": @json($kelasList)},
                                                "tanggal": {"label": "Tanggal", "type":"date", "placeholder":"Pilih tanggal absensi"},
                                                "status": {"label": "Status", "type": "select", "placeholder":"Pilih status", "options": {"Hadir":"Hadir","Izin":"Izin","Sakit":"Sakit","Alpa":"Alpa"}},
                                                "keterangan": {"label": "Keterangan", "type": "textarea", "placeholder":"Tambahkan keterangan"}
                                            }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Absensi --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Absensi"
                                                data-url="{{ route('guru.absensi.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
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
