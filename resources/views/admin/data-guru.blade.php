@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Data Guru')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Daftar Guru</h4>
                <div class="d-flex gap-2">
                    {{-- Sort --}}
                    <select class="form-select form-select-sm" data-sort data-target="#guruTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">A-Z</option>
                        <option value="nama_desc">Z-A</option>
                    </select>

                    {{-- Tambah Guru --}}
                    <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Guru"
                        data-url="{{ route('admin.guru.store') }}"
                        data-fields='{
                        "nama_lengkap": {"label": "Nama Lengkap", "placeholder":"Masukkan nama lengkap guru", "hint":"Gunakan huruf sesuai KTP."},
                        "jenis_kelamin": {"label": "Jenis Kelamin", "type": "select", "options": ["Laki-laki","Perempuan"], "placeholder":"Pilih jenis kelamin"},
                        "tanggal_lahir": {"label": "Tanggal Lahir", "placeholder":"Contoh: 01-01-1990", "hint":"Tuliskan tanggal lahir lengkap."},
                        "agama": {"label": "Agama", "type": "select", "options": ["Islam","Kristen","Katolik","Hindu","Buddha","Konghucu","Lainnya"], "placeholder":"Pilih agama guru"},
                        "pendidikan_terakhir": {"label": "Pendidikan Terakhir", "placeholder":"Masukkan pendidikan terakhir"},
                        "no_hp": {"label": "Nomor HP", "placeholder":"Masukkan nomor HP aktif"},
                        "alamat": {"label": "Alamat", "placeholder":"Masukkan alamat lengkap"},
                        "username": {"label": "Username", "placeholder":"Buat username"},
                        "email": {"label": "Email", "placeholder":"Masukkan email aktif"},
                        "password": {"label": "Password", "type":"password", "placeholder":"Buat password minimal 6 karakter"}
                    }'>
                        <i class="fas fa-plus me-1"></i> Tambah Guru
                    </button>

                    {{-- Export --}}
                    <a href="{{ route('admin.guru.export') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Agama</th>
                                <th>Pendidikan Terakhir</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="guruTableBody">
                            @forelse ($guru as $item)
                                <tr>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->kelas->nama_kelas }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>{{ $item->agama }}</td>
                                    <td>{{ $item->pendidikan_terakhir }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->pengguna->username }}</td>
                                    <td>{{ $item->pengguna->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Guru --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Guru"
                                                data-url="{{ route('admin.guru.update', $item->pengguna_id) }}"
                                                data-fields='{
                                                "nama_lengkap": {"label": "Nama Lengkap", "placeholder":"Masukkan nama lengkap guru"},
                                                "jenis_kelamin": {"label": "Jenis Kelamin", "type":"select", "options":["Laki-laki","Perempuan"], "placeholder":"Pilih jenis kelamin"},
                                                "tanggal_lahir": {"label": "Tanggal Lahir", "placeholder":"Contoh: 01-01-1990"},
                                                "agama": {"label": "Agama", "type":"select", "options":["Islam","Kristen","Katolik","Hindu","Buddha","Konghucu","Lainnya"], "placeholder":"Pilih agama"},
                                                "pendidikan_terakhir": {"label": "Pendidikan Terakhir", "placeholder":"Masukkan pendidikan terakhir"},
                                                "no_hp": {"label": "Nomor HP", "placeholder":"Masukkan nomor HP aktif"},
                                                "alamat": {"label": "Alamat", "placeholder":"Masukkan alamat lengkap"}
                                            }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Guru --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Guru"
                                                data-url="{{ route('admin.guru.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
