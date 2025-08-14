@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Data Siswa')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white ms-5">Daftar Siswa</h4>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" data-sort data-target="#siswaTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">A-Z</option>
                        <option value="nama_desc">Z-A</option>
                    </select>

                    {{-- Tambah Siswa --}}
                    <button class="btn bg-light text-muted text-nowrap" data-crud="add" data-method="POST"
                        data-title="Tambah Siswa" data-url="{{ route('admin.siswa.store') }}"
                        data-fields='{
                        "nama_lengkap": {"label": "Nama Lengkap", "placeholder":"Masukkan nama lengkap siswa", "hint":"Gunakan huruf sesuai akta kelahiran."},
                        "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                        "nama_panggilan": {"label": "Nama Panggilan", "placeholder":"Masukkan nama panggilan", "hint":"Nama sehari-hari siswa."},
                        "jenis_kelamin": {"label": "Jenis Kelamin", "type": "select", "placeholder":"Pilih jenis kelamin", "options": ["Laki-laki","Perempuan"], "hint":"Pilih salah satu."},
                        "tempat_tanggal_lahir": {"label": "Tempat & Tanggal Lahir", "placeholder":"Contoh: Jakarta, 01-01-2018", "hint":"Tuliskan tempat dan tanggal lahir lengkap."},
                        "agama": {"label": "Agama", "type": "select", "placeholder": "Pilih agama siswa", "options": ["Islam","Kristen","Katolik","Hindu","Buddha","Konghucu","Lainnya"], "hint": "Silakan pilih sesuai keyakinan siswa."},
                        "anak_ke": {"label": "Anak Ke", "type":"number", "placeholder":"Masukkan urutan anak", "hint":"Urutan anak dalam keluarga."},
                        "nama_ayah": {"label": "Nama Ayah", "placeholder":"Masukkan nama ayah", "hint":"Gunakan nama lengkap ayah."},
                        "nama_ibu": {"label": "Nama Ibu", "placeholder":"Masukkan nama ibu", "hint":"Gunakan nama lengkap ibu."},
                        "pekerjaan_ayah": {"label": "Pekerjaan Ayah", "placeholder":"Masukkan pekerjaan ayah", "hint":"Tuliskan pekerjaan ayah secara jelas."},
                        "pekerjaan_ibu": {"label": "Pekerjaan Ibu", "placeholder":"Masukkan pekerjaan ibu", "hint":"Tuliskan pekerjaan ibu secara jelas."},
                        "no_hp": {"label": "Nomor HP", "placeholder":"Masukkan nomor HP", "hint":"Gunakan nomor HP aktif."},
                        "alamat": {"label": "Alamat", "placeholder":"Masukkan alamat lengkap", "hint":"Tuliskan alamat tempat tinggal lengkap."},
                        "username": {"label": "Username", "placeholder":"Buat username", "hint":"Gunakan kombinasi huruf/angka unik."},
                        "email": {"label": "Email", "placeholder":"Masukkan email", "hint":"Gunakan email aktif untuk login."},
                        "password": {"label": "Password", "type":"password", "placeholder":"Buat password", "hint":"Gunakan password minimal 6 karakter."}
                    }'>
                        <i class="fas fa-plus me-1"></i> Tambah Siswa
                    </button>

                    {{-- Export --}}
                    <a href="{{ route('admin.siswa.export') }}" class="btn bg-light text-muted text-nowrap btn-sm">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Nama Lengkap</th>
                                <th>Kelas</th>
                                <th>Nama Panggilan</th>
                                <th>Jenis Kelamin</th>
                                <th>TTL</th>
                                <th>Agama</th>
                                <th>Anak Ke</th>
                                <th>Nama Ayah</th>
                                <th>Nama Ibu</th>
                                <th>Pekerjaan Ayah</th>
                                <th>Pekerjaan Ibu</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTableBody">
                            @forelse ($siswa as $item)
                                <tr class="text-center">
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ 'TK ' . $item->kelas->tingkat }}
                                    </td>
                                    <td>{{ $item->nama_panggilan }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->tempat_tanggal_lahir }}</td>
                                    <td>{{ $item->agama }}</td>
                                    <td>{{ $item->anak_ke }}</td>
                                    <td>{{ $item->nama_ayah }}</td>
                                    <td>{{ $item->nama_ibu }}</td>
                                    <td>{{ $item->pekerjaan_ayah }}</td>
                                    <td>{{ $item->pekerjaan_ibu }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->pengguna->username }}</td>
                                    <td>{{ $item->pengguna->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Siswa --}}
                                            <button class="btn btn-warning btn-sm" data-crud="edit" data-method="PUT"
                                                data-title="Edit Siswa"
                                                data-url="{{ route('admin.siswa.update', $item->pengguna_id) }}"
                                                data-fields='{
                                            "nama_lengkap": {"label": "Nama Lengkap", "placeholder":"Masukkan nama lengkap siswa", "hint":"Gunakan huruf sesuai akta kelahiran."},
                                            "kelas_id": {"label": "Kelas", "type":"select", "placeholder":"Pilih kelas", "options": @json($kelasList), "hint":"Pilih kelas siswa."},
                                            "nama_panggilan": {"label": "Nama Panggilan", "placeholder":"Masukkan nama panggilan", "hint":"Nama sehari-hari siswa."},
                                            "jenis_kelamin": {"label": "Jenis Kelamin", "type": "select", "placeholder":"Pilih jenis kelamin", "options":["Laki-laki","Perempuan"], "hint":"Pilih salah satu."},
                                            "tempat_tanggal_lahir": {"label": "Tempat & Tanggal Lahir", "placeholder":"Contoh: Jakarta, 01-01-2018", "hint":"Tuliskan tempat dan tanggal lahir lengkap."},
                                            "agama": {"label": "Agama", "type": "select", "placeholder": "Pilih agama siswa", "options": ["Islam","Kristen","Katolik","Hindu","Buddha","Konghucu","Lainnya"], "hint": "Silakan pilih sesuai keyakinan siswa."},
                                            "anak_ke": {"label": "Anak Ke", "type":"number", "placeholder":"Masukkan urutan anak", "hint":"Urutan anak dalam keluarga."},
                                            "nama_ayah": {"label": "Nama Ayah", "placeholder":"Masukkan nama ayah", "hint":"Gunakan nama lengkap ayah."},
                                            "nama_ibu": {"label": "Nama Ibu", "placeholder":"Masukkan nama ibu", "hint":"Gunakan nama lengkap ibu."},
                                            "pekerjaan_ayah": {"label": "Pekerjaan Ayah", "placeholder":"Masukkan pekerjaan ayah", "hint":"Tuliskan pekerjaan ayah secara jelas."},
                                            "pekerjaan_ibu": {"label": "Pekerjaan Ibu", "placeholder":"Masukkan pekerjaan ibu", "hint":"Tuliskan pekerjaan ibu secara jelas."},
                                            "no_hp": {"label": "Nomor HP", "placeholder":"Masukkan nomor HP", "hint":"Gunakan nomor HP aktif."},
                                            "alamat": {"label": "Alamat", "placeholder":"Masukkan alamat lengkap", "hint":"Tuliskan alamat tempat tinggal lengkap."}
                                        }'
                                                data-values='@json($item)'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Delete Siswa --}}
                                            <button class="btn btn-danger btn-sm" data-crud="delete" data-method="DELETE"
                                                data-title="Hapus Siswa"
                                                data-url="{{ route('admin.siswa.delete', $item->id) }}" data-fields='{}'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center text-muted">Tidak ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
