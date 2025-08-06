@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Data Pembayaran')
@section('content')
    <section class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-white">Daftar Pembayaran</h4>
                <div class="d-flex gap-2">
                    {{-- Sort --}}
                    <select class="form-select form-select-sm" data-sort data-target="#pembayaranTableBody">
                        <option value="default">Sort by</option>
                        <option value="nama_asc">Nama A-Z</option>
                        <option value="nama_desc">Nama Z-A</option>
                        <option value="tanggal_asc">Tanggal Terlama</option>
                        <option value="tanggal_desc">Tanggal Terbaru</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaranTableBody">
                            @forelse($pembayaran as $item)
                                <tr>
                                    <td>{{ $item->siswa->nama_lengkap }}</td>
                                    <td>{{ $item->tanggal_pembayaran }}</td>
                                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($item->metode) }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($item->status == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->bukti_pembayaran)
                                            <a href="{{ asset('uploads/bukti/' . $item->bukti_pembayaran) }}"
                                                target="_blank">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status == 'pending')
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- Approve Pembayaran --}}
                                                <button class="btn btn-success btn-sm" data-crud="approve" data-method="PUT"
                                                    data-title="Approve Pembayaran"
                                                    data-url="{{ route('admin.pembayaran.approve', $item->id) }}"
                                                    data-fields='{}'>
                                                    <i class="fas fa-check"></i> Approve
                                                </button>

                                                {{-- Reject Pembayaran --}}
                                                <button class="btn btn-danger btn-sm" data-crud="reject" data-method="PUT"
                                                    data-title="Reject Pembayaran"
                                                    data-url="{{ route('admin.pembayaran.reject', $item->id) }}"
                                                    data-fields='{}'>
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
