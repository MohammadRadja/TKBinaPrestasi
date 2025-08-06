@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Data Nilai Siswa')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Daftar Nilai Siswa</h4>
                <div class="d-flex gap-2">
                    {{-- Sorting --}}
                    <select class="form-select form-select-sm" data-sort data-target="#nilaiTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">Nama (A-Z)</option>
                        <option value="nama_desc">Nama (Z-A)</option>
                        <option value="tanggal_asc">Tanggal (Terlama)</option>
                        <option value="tanggal_desc">Tanggal (Terbaru)</option>
                        <option value="nilai_asc">Nilai (Terendah)</option>
                        <option value="nilai_desc">Nilai (Tertinggi)</option>
                    </select>

                    {{-- Tambah Nilai --}}
                    <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Nilai"
                        data-url="{{ route('admin.nilai.store') }}"
                        data-fields='{
                        "guru_id": {"label": "Guru Penilai", "type": "select", "placeholder": "Pilih guru penilai", "options": @json($guruList), "hint":"Guru yang memberikan nilai."},
                        "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList), "hint":"Pilih siswa yang dinilai."},
                        "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                        "mata_pelajaran": {"label": "Mata Pelajaran", "placeholder": "Masukkan mata pelajaran", "hint":"Nama mata pelajaran."},
                        "nilai": {"label": "Nilai", "type": "number", "placeholder": "Masukkan nilai", "hint":"Nilai siswa (0-100)."},
                        "keterangan": {"label": "Keterangan", "type": "textarea", "placeholder": "Tambahkan keterangan (opsional)", "hint":"Deskripsi tambahan hasil penilaian."},
                        "tanggal_input": {"label": "Tanggal Input", "type": "date", "placeholder": "Pilih tanggal input", "hint":"Tanggal penilaian dimasukkan."}
                    }'>
                        <i class="fas fa-plus me-1"></i> Tambah Nilai
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Keterangan</th>
                                <th>Guru Penilai</th>
                                <th>Tanggal Input</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="nilaiTableBody">
                            @forelse($nilai as $item)
                                <tr>
                                    <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                                    <td>{{ 'TK ' . $item->kelas->tingkat . ' - ' . $item->kelas->nama_kelas . ' (' . $item->kelas->tahun_ajaran . ')' }}
                                    </td>
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->mata_pelajaran }}</td>
                                    <td>
                                        @php
                                            $badge =
                                                $item->nilai < 50
                                                    ? 'bg-danger'
                                                    : ($item->nilai < 75
                                                        ? 'bg-warning text-dark'
                                                        : 'bg-success');
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $item->nilai }}</span>
                                    </td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Nilai --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Nilai"
                                                data-url="{{ route('admin.nilai.update', $item->id) }}"
                                                data-fields='{
                                            "guru_id": {"label": "Guru Penilai", "type": "select", "placeholder": "Pilih guru penilai", "options": @json($guruList), "hint":"Guru yang memberikan nilai."},
                                            "siswa_id": {"label": "Nama Siswa", "type": "select", "placeholder": "Pilih siswa", "options": @json($siswaList), "hint":"Pilih siswa yang dinilai."},
                                            "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                                            "mata_pelajaran": {"label": "Mata Pelajaran", "placeholder": "Masukkan mata pelajaran", "hint":"Nama mata pelajaran."},
                                            "nilai": {"label": "Nilai", "type": "number", "placeholder": "Masukkan nilai", "hint":"Nilai siswa (0-100)."},
                                            "keterangan": {"label": "Keterangan", "type": "textarea", "placeholder": "Tambahkan keterangan", "hint":"Deskripsi tambahan hasil penilaian."},
                                            "tanggal_input": {"label": "Tanggal Input", "type": "date", "placeholder": "Pilih tanggal input", "hint":"Tanggal penilaian dimasukkan."}
                                        }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Nilai --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Nilai"
                                                data-url="{{ route('admin.nilai.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data nilai siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
