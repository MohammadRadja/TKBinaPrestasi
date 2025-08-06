<!-- View untuk tampilan balasan -->
<div class="message reply ms-{{ $level * 4 }} mt-3 p-2 border-start border-3 rounded-start"
    style="border-color: #007bff;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <i class="fas fa-user-circle fa-lg text-primary"></i>
            <span class="message-author fw-bold">
                {{ $reply->pengguna ? $reply->pengguna->nama_lengkap : 'Unknown' }}
                ({{ $reply->pengguna->role ?? 'not available' }})
            </span>
            <span
                class="message-time text-muted">{{ \Carbon\Carbon::parse($reply->waktu_kirim)->locale('id')->diffForHumans() }}</span>
        </div>
    </div>
    <p class="message-content">{{ $reply->isi_pesan }}</p>
    <!-- Tambahkan kontrol edit dan hapus untuk balasan -->
    @if ($reply->pengguna_id == Session::get('pengguna_id'))
        <div class="mt-2 d-flex">
            <a href="#" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                data-bs-target="#editReplyModal{{ $reply->id }}">Edit</a>
            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#deleteReplyModal{{ $reply->id }}">Hapus</button>
        </div>
    @endif
    <!-- Tombol balasan muncul hanya jika balasan dibuat oleh orang lain -->
    @if ($reply->pengguna_id != Session::get('pengguna_id'))
        @if ($reply->pengguna)
            <button class="btn btn-link btn-sm mt-1 mb-1 text-primary btn-reply-toggle"
                data-pesan-id="{{ $reply->id }}" data-pengguna-nama="{{ $reply->pengguna->nama_lengkap }}">
                Balas
            </button>
        @else
            <button class="btn btn-link btn-sm mt-1 mb-1 text-primary btn-reply-toggle"
                data-pesan-id="{{ $reply->id }}" data-pengguna-nama="Unknown">
                Balas
            </button>
        @endif
    @endif
    <!-- Formulir balasan -->
    <form action="{{ route('forum.pesan.kirim') }}" method="POST" class="mb-2 reply-form"
        data-pesan-id="{{ $reply->id }}" style="display: none;">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
        <div class="input-group">
            <textarea name="isi_pesan" class="form-control" placeholder="Balas pesan..." rows="2"></textarea>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </div>
    </form>
    <!-- Menampilkan balasan pada balasan -->
    @foreach ($reply->replies as $childReply)
        @include('forum.reply', ['reply' => $childReply, 'level' => $level + 1])
    @endforeach
    <!-- Modal Edit Balasan -->
    <div class="modal fade" id="editReplyModal{{ $reply->id }}" tabindex="-1"
        aria-labelledby="editReplyModalLabel{{ $reply->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('forum.pesan.reply.update', $reply->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReplyModalLabel{{ $reply->id }}">Edit Balasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="isi_reply{{ $reply->id }}" class="form-label">Isi Balasan</label>
                            <textarea class="form-control" id="isi_reply{{ $reply->id }}" name="isi_pesan" rows="5">{{ $reply->isi_pesan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Hapus Balasan -->
    <div class="modal fade" id="deleteReplyModal{{ $reply->id }}" tabindex="-1"
        aria-labelledby="deleteReplyModalLabel{{ $reply->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('forum.pesan.hapus', $reply->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteReplyModalLabel{{ $reply->id }}">Konfirmasi Hapus Balasan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus balasan ini?</p>
                        <p class="fw-bold">{{ $reply->isi_pesan }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>