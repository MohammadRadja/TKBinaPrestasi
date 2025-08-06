@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Biodata Siswa')

@section('content')
    <div class="container my-5">
        <div class="col-lg-9 mx-auto">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold text-white">📝 Formulir Biodata Siswa</h4>
                    <small>Lengkapi data berikut untuk pendaftaran TKIT Bina Prestasi</small>
                </div>

                <div class="card-body p-4">
                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            ✅ {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            ❌ {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('siswa.biodata.save') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION 1 : DATA SISWA -->
                        <h5 class="fw-bold text-success mb-3">I. Data Siswa</h5>
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th width="30%">Nama Lengkap</th>
                                    <td>
                                        <input type="text" name="fullName"
                                            class="form-control @error('fullName') is-invalid @enderror"
                                            value="{{ old('fullName', $biodata->nama_lengkap ?? '') }}" required>
                                        @error('fullName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Panggilan</th>
                                    <td><input type="text" name="nickName" class="form-control"
                                            value="{{ old('nickName', $biodata->nama_panggilan ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        <select name="gender" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki"
                                                {{ old('gender', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="Perempuan"
                                                {{ old('gender', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td><input type="text" name="birthPlaceDate" class="form-control"
                                            placeholder="Contoh: Jakarta, 01 Januari 2020"
                                            value="{{ old('birthPlaceDate', $biodata->tempat_tanggal_lahir ?? '') }}"
                                            required></td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>
                                        <select name="agama" class="form-select" required>
                                            <option value="">Pilih Agama</option>
                                            @foreach (['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                                                <option value="{{ $religion }}"
                                                    {{ old('agama', $biodata->agama ?? '') == $religion ? 'selected' : '' }}>
                                                    {{ $religion }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Anak ke-</th>
                                    <td><input type="number" name="anakKe" class="form-control"
                                            value="{{ old('anakKe', $biodata->anak_ke ?? '') }}" required></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- SECTION 2 : DATA ORANG TUA -->
                        <h5 class="fw-bold text-success mt-4 mb-3">II. Data Orang Tua</h5>
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th>Nama Ayah</th>
                                    <td><input type="text" name="parentNameAyah" class="form-control"
                                            value="{{ old('parentNameAyah', $biodata->nama_ayah ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>Profesi Ayah</th>
                                    <td><input type="text" name="profesiayah" class="form-control"
                                            value="{{ old('profesiayah', $biodata->pekerjaan_ayah ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td><input type="text" name="parentNameIbu" class="form-control"
                                            value="{{ old('parentNameIbu', $biodata->nama_ibu ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>Profesi Ibu</th>
                                    <td><input type="text" name="profesiibu" class="form-control"
                                            value="{{ old('profesiibu', $biodata->pekerjaan_ibu ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>No. HP/WhatsApp Ayah</th>
                                    <td><input type="text" name="telayah" class="form-control" placeholder="08123456789"
                                            value="{{ old('telayah', $biodata->no_hp ?? '') }}" required></td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>
                                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $biodata->alamat ?? '') }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fw-bold text-success mt-4 mb-3">III. Berkas Penunjang</h5>
                        <table class="table table-bordered align-middle">
                            <tbody>
                                @php
                                    $fileMap =
                                        $biodata?->berkas->keyBy(fn($b) => Str::slug($b->jenis_berkas, '_')) ??
                                        collect();
                                @endphp

                                <tr>
                                    <th>Akta Kelahiran</th>
                                    <td>
                                        @if (isset($fileMap['akta_kelahiran']))
                                            <a href="{{ asset($fileMap['akta_kelahiran']->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-success mb-2">📂 Lihat Berkas</a>
                                        @endif
                                        <input type="file" name="berkas[akta_kelahiran]" class="form-control"
                                            accept="image/*,.pdf">
                                        <small class="text-muted">Format: JPG/PNG/PDF, ukuran maksimal 2MB.</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Kartu Keluarga</th>
                                    <td>
                                        @if (isset($fileMap['kartu_keluarga']))
                                            <a href="{{ asset($fileMap['kartu_keluarga']->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-success mb-2">📂 Lihat Berkas</a>
                                        @endif
                                        <input type="file" name="berkas[kartu_keluarga]" class="form-control"
                                            accept="image/*,.pdf">
                                        <small class="text-muted">Format: JPG/PNG/PDF, ukuran maksimal 2MB.</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Ijazah (TK/PAUD jika ada)</th>
                                    <td>
                                        @if (isset($fileMap['ijazah']))
                                            <a href="{{ asset($fileMap['ijazah']->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-success mb-2">📂 Lihat Berkas</a>
                                        @endif
                                        <input type="file" name="berkas[ijazah]" class="form-control"
                                            accept="image/*,.pdf">
                                        <small class="text-muted">Format: JPG/PNG/PDF, ukuran maksimal 2MB.</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Pas Foto</th>
                                    <td>
                                        @if (isset($fileMap['foto']))
                                            <img src="{{ asset($fileMap['foto']->file_path) }}" alt="Foto Siswa"
                                                width="100" class="img-thumbnail mb-2">
                                        @endif
                                        <input type="file" name="berkas[foto]" class="form-control" accept="image/*">
                                        <small class="text-muted">Format: JPG/PNG/PDF, ukuran maksimal 2MB.</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>KTP Orang Tua</th>
                                    <td>
                                        @if (isset($fileMap['ktp_orang_tua']))
                                            <img src="{{ asset($fileMap['ktp_orang_tua']->file_path) }}" alt="Foto Siswa"
                                                width="100" class="img-thumbnail mb-2">
                                        @endif
                                        <input type="file" name="berkas[ktp_orang_tua]" class="form-control"
                                            accept="image/*">
                                        <small class="text-muted">Format: JPG/PNG/PDF, ukuran maksimal 2MB.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- BUTTON -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Simpan Biodata
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
