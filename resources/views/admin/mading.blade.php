@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Mading')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white ms-5">Daftar Surat Pemberitahuan</h4>
                <div class="d-flex gap-2">
                    {{-- Tambah Mading --}}
                    <button class="btn bg-light text-muted" data-crud="add" data-method="POST" data-title="Tambah Mading"
                        data-url="{{ route('admin.mading.store') }}"
                        data-fields='{
                            "judul": {"label": "Judul", "placeholder":"Masukkan judul pemberitahuan", "hint":"Gunakan judul yang singkat dan jelas."},
                            "isi": {"label": "Isi", "type":"textarea", "placeholder":"Masukkan isi pemberitahuan", "hint":"Tuliskan isi surat pemberitahuan secara lengkap."},
                            "target_role": {"label": "Target Role", "type":"select", "placeholder":"Pilih target penerima", "options":["Guru","Orangtua","Siswa"], "hint":"Pilih peran yang dituju oleh pemberitahuan ini."}
                        }'>
                        <i class="fas fa-plus me-1"></i> Tambah Mading
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Judul</th>
                                <th>Isi</th>
                                <th class="text-center">Target Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="madingTableBody">
                            @forelse ($mading as $item)
                                <tr class="text-center">
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->isi }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">{{ strtoupper($item->target_role) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Mading --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Mading"
                                                data-url="{{ route('admin.mading.update', $item->id) }}"
                                                data-fields='{
                                                    "judul": {"label": "Judul", "placeholder":"Masukkan judul pemberitahuan", "hint":"Gunakan judul yang singkat dan jelas."},
                                                    "isi": {"label": "Isi", "type":"textarea", "placeholder":"Masukkan isi pemberitahuan", "hint":"Tuliskan isi surat pemberitahuan secara lengkap."},
                                                    "target_role": {"label": "Target Role", "type":"select", "placeholder":"Pilih target penerima", "options":["Guru","Orangtua","Siswa"], "hint":"Pilih peran yang dituju oleh pemberitahuan ini."}
                                                }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Mading --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Mading"
                                                data-url="{{ route('admin.mading.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada surat pemberitahuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
