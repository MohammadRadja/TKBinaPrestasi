@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Data Kelas')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Daftar Kelas</h4>
                <div class="d-flex gap-2">
                    {{-- Tambah Kelas --}}
                    <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Kelas"
                        data-url="{{ route('admin.kelas.store') }}"
                        data-fields='{
                        "nama_kelas": {"label": "Nama Kelas", "placeholder":"Masukkan nama kelas", "hint":"Contoh: Kelas A, Kelas B, Kelas C."},
                        "tingkat": {"label": "Tingkat", "placeholder":"Masukkan tingkat kelas", "hint":"Contoh: A atau B."},
                        "kapasitas": {"label": "Kapasitas", "type":"number", "placeholder":"Masukkan kapasitas siswa", "hint":"Jumlah maksimal siswa di kelas."},
                        "tahun_ajaran": {"label": "Tahun Ajaran", "placeholder":"Contoh: 2024/2025", "hint":"Gunakan format tahun ajaran."},
                        "guru_id": {"label": "Wali Kelas", "type":"select", "placeholder":"Pilih wali kelas", "options": @json($guruList), "hint":"Pilih guru yang menjadi wali kelas."}
                    }'>
                        <i class="fas fa-plus me-1"></i> Tambah Kelas
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Kapasitas</th>
                                <th>Tahun Ajaran</th>
                                <th>Wali Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $item)
                                <tr>
                                    <td>{{ $item->nama_kelas }}</td>
                                    <td>{{ $item->tingkat }}</td>
                                    <td>{{ $item->kapasitas }}</td>
                                    <td>{{ $item->tahun_ajaran }}</td>
                                    <td>{{ $item->guru->nama_lengkap }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Kelas --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Kelas"
                                                data-url="{{ route('admin.kelas.update', $item->id) }}"
                                                data-fields='{
                                                "nama_kelas": {"label": "Nama Kelas", "placeholder":"Masukkan nama kelas", "hint":"Contoh: A, B, C."},
                                                "tingkat": {"label": "Tingkat", "placeholder":"Masukkan tingkat kelas", "hint":"Contoh: TK A atau TK B."},
                                                "kapasitas": {"label": "Kapasitas", "type":"number", "placeholder":"Masukkan kapasitas siswa", "hint":"Jumlah maksimal siswa di kelas."},
                                                "tahun_ajaran": {"label": "Tahun Ajaran", "placeholder":"Contoh: 2024/2025", "hint":"Gunakan format tahun ajaran."},
                                                "guru_id": {"label": "Wali Kelas", "type":"select", "placeholder":"Pilih wali kelas", "options": @json($guruList), "hint":"Pilih guru yang menjadi wali kelas."}
                                            }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Kelas --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Kelas"
                                                data-url="{{ route('admin.kelas.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data kelas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
