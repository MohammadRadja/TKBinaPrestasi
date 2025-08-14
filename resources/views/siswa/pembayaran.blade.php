@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Pembayaran Siswa')

@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            {{-- Header --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Riwayat Pembayaran Saya</h4>
                <button class="btn btn-light text-muted" data-crud="add" data-method="POST" data-title="Tambah Pembayaran"
                    data-url="{{ route('siswa.pembayaran.store') }}"
                    data-fields='{
                    "jenis_pembayaran": {"label":"Jenis Pembayaran","type":"select","options":["pendaftaran","seragam","spp","lainnya"],"placeholder":"Pilih jenis pembayaran"},
                    "jumlah": {"label":"Jumlah","placeholder":"Masukkan jumlah"},
                    "metode": {"label":"Metode","type":"select","options":["transfer","tunai"],"placeholder":"Pilih metode"},
                    "tanggal_pembayaran": {"label":"Tanggal Pembayaran","type":"date"},
                    "bukti_pembayaran": {"label":"Bukti Pembayaran","type":"file","placeholder":"Upload bukti"}
                }'>
                    <i class="fas fa-plus me-1"></i> Tambah Pembayaran
                </button>
            </div>

            {{-- Body --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaran as $item)
                                <tr>
                                    <td>{{ ucfirst($item->jenis_pembayaran) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d M Y') }}</td>
                                    <td><span class="fw-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                    </td>
                                    <td>{{ ucfirst($item->metode) }}</td>
                                    <td>
                                        @if ($item->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($item->status === 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->bukti_pembayaran)
                                            <a href="{{ asset('asset/img/bukti_pembayaran/' . $item->bukti_pembayaran) }}"
                                                target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status === 'pending')
                                            <div class="btn-group">
                                                {{-- Edit Pembayaran --}}
                                                <button class="btn btn-outline-warning btn-sm" data-crud="edit"
                                                    data-method="PUT" data-title="Edit Pembayaran"
                                                    data-url="{{ route('siswa.pembayaran.update', $item->id) }}"
                                                    data-fields='{
                                                    "jenis_pembayaran": {"label":"Jenis Pembayaran","type":"select","options":["pendaftaran","seragam","spp","lainnya"]},
                                                    "jumlah": {"label":"Jumlah"},
                                                    "metode": {"label":"Metode","type":"select","options":["transfer","tunai"]},
                                                    "tanggal_pembayaran": {"label":"Tanggal Pembayaran","type":"date"},
                                                    "bukti_pembayaran": {"label":"Bukti Pembayaran","type":"file"}
                                                }'
                                                    data-values='@json($item)'>
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                {{-- Delete Pembayaran --}}
                                                <button class="btn btn-outline-danger btn-sm" data-crud="delete"
                                                    data-method="DELETE" data-title="Hapus Pembayaran"
                                                    data-url="{{ route('siswa.pembayaran.delete', $item->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i><br>
                                            Belum ada riwayat pembayaran.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
