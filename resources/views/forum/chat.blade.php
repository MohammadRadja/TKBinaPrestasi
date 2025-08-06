@extends('layouts.auth.app')
@section('judul', 'TKIT BINA PRESTASI - Forum Chat')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <!-- Tombol untuk menampilkan kolom input utama -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white" style="text-align: center">Forum Chat</div>
                    <div class="card-body">
                        <div class="chat-container">
                            <div class="chat-messages mb-4">
                                <!-- Daftar pesan -->
                                @foreach ($pesanList as $pesan)
                                    <div class="message mb-3 p-3 border rounded bg-light">
                                        <!-- Konten pesan -->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <i class="fas fa-user-circle fa-lg text-primary"></i>
                                                <span class="message-author fw-bold">
                                                    {{ $pesan->pengguna ? $pesan->pengguna->nama_lengkap : 'Unknown' }}
                                                    ({{ $pesan->pengguna->role ?? 'not available' }})
                                                </span>
                                                <span
                                                    class="message-time text-muted">{{ \Carbon\Carbon::parse($pesan->waktu_kirim)->locale('id')->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <p class="message-content">{!! nl2br(e($pesan->isi_pesan)) !!}</p>
                                        @if ($pesan->pengguna_id == Session::get('pengguna_id'))
                                            <div class="mt-2 d-flex">
                                                <a href="#" class="btn btn-sm btn-outline-primary me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPesanModal{{ $pesan->id }}">Edit</a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusPesanModal{{ $pesan->id }}">Hapus</button>
                                            </div>
                                        @else
                                            <button class="btn btn-link btn-sm mt-1 mb-1 text-primary btn-reply-toggle"
                                                data-pesan-id="{{ $pesan->id }}"
                                                data-pengguna-nama="{{ $pesan->pengguna ? $pesan->pengguna->nama_lengkap : 'Unknown' }}">Balas</button>
                                        @endif
                                        <!-- Formulir Balasan Pesan -->
                                        <form action="{{ route('forum.pesan.kirim') }}" method="POST"
                                            class="mb-2 reply-form" data-pesan-id="{{ $pesan->id }}"
                                            style="display: none;">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $pesan->id }}">
                                            <div class="input-group">
                                                <textarea name="isi_pesan" class="form-control" placeholder="Balas pesan..." rows="2"></textarea>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                        @foreach ($pesan->replies as $reply)
                                            @include('forum.reply', ['reply' => $reply, 'level' => 1])
                                        @endforeach
                                    </div>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editPesanModal{{ $pesan->id }}" tabindex="-1"
                                        aria-labelledby="editPesanModalLabel{{ $pesan->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('forum.pesan.update', $pesan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editPesanModalLabel{{ $pesan->id }}">Edit Pesan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="isi_pesan{{ $pesan->id }}"
                                                                class="form-label">Isi Pesan</label>
                                                            <textarea class="form-control" id="isi_pesan{{ $pesan->id }}" name="isi_pesan" rows="5">{{ $pesan->isi_pesan }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="hapusPesanModal{{ $pesan->id }}" tabindex="-1"
                                        aria-labelledby="hapusPesanModalLabel{{ $pesan->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('forum.pesan.hapus', $pesan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusPesanModalLabel{{ $pesan->id }}">Hapus Pesan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus pesan ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-start mb-2">
                    <button id="show-main-input" class="btn btn-primary">Tulis Pesan Baru</button>
                </div>
                <!-- Kolom Input Utama -->
                <div id="main-input-container" class="fixed bg-light p-3 shadow-sm" style="display: none;">
                    <form id="main-input-form" action="{{ route('forum.pesan.kirim') }}" method="POST" class="mb-0">
                        @csrf
                        <div class="input-group">
                            <textarea name="isi_pesan" class="form-control" placeholder="Tulis pesan..." rows="2"></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.btn-reply-toggle');
            const showMainInputButton = document.getElementById('show-main-input');
            const mainInputContainer = document.getElementById('main-input-container');
            const mainInputForm = document.getElementById('main-input-form');
            // Menangani klik pada tombol "Tulis Pesan Baru"
            showMainInputButton.addEventListener('click', function() {
                mainInputContainer.style.display = 'block';
                mainInputForm.querySelector('textarea[name="isi_pesan"]').focus();
                // Sembunyikan semua form balasan
                document.querySelectorAll('.reply-form').forEach(form => {
                    form.style.display = 'none';
                });
            });
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pesanId = this.getAttribute('data-pesan-id');
                    const replyForm = document.querySelector(
                        `.reply-form[data-pesan-id="${pesanId}"]`);
                    const inputField = replyForm.querySelector('textarea[name="isi_pesan"]');
                    // Sembunyikan kolom input utama
                    mainInputContainer.style.display = 'none';
                    // Sembunyikan form balasan jika sudah terbuka
                    document.querySelectorAll('.reply-form').forEach(form => {
                        if (form !== replyForm) {
                            form.style.display = 'none';
                        }
                    });
                    // Tampilkan form balasan
                    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                    inputField.focus();
                });
            });
            // Jika form balasan ditutup, tampilkan kembali kolom input utama
            document.addEventListener('click', function(event) {
                if (!event.target.classList.contains('btn-reply-toggle') && !event.target.closest(
                        '#main-input-container')) {
                    const replyForms = document.querySelectorAll('.reply-form');
                    replyForms.forEach(form => {
                        if (form.style.display === 'block') {
                            form.style.display = 'none';
                        }
                    });
                    if (mainInputContainer.style.display === 'none') {
                        mainInputContainer.style.display = 'block';
                    }
                }
            });
        });
    </script>
@endsection