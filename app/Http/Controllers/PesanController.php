<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\Pengguna; // Pastikan mengimport model Pengguna jika diperlukan
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function index()
    {
        $pesanList = Pesan::with(['pengguna', 'replies.replies.replies']) // Load replies recursively
            ->whereNull('parent_id')
            ->orderBy('waktu_kirim', 'asc')
            ->get();

        // Convert waktu_kirim to Carbon with timezone
        foreach ($pesanList as $pesan) {
            $pesan->waktu_kirim = Carbon::parse($pesan->waktu_kirim)->timezone('Asia/Jakarta');
            $this->convertRepliesTimezone($pesan->replies);
        }


        return view('forum.chat', [
            'pesanList' => $pesanList,
        ]);
    }

    private function convertRepliesTimezone($replies)
    {
        foreach ($replies as $reply) {
            $reply->waktu_kirim = Carbon::parse($reply->waktu_kirim)->timezone('Asia/Jakarta');
            if ($reply->replies) {
                $this->convertRepliesTimezone($reply->replies);
            }
        }
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'isi_pesan' => 'required|string',
        ]);

        $parent_id = $request->input('parent_id'); // If it's a reply

        Pesan::create([
            'pengguna_id' => Session::get('pengguna_id'),
            'isi_pesan' => $request->isi_pesan,
            'waktu_kirim' => Carbon::now()->timezone('Asia/Jakarta'), // Set waktu sekarang dengan timezone yang sesuai
            'parent_id' => $parent_id, // Set parent_id for replies
        ]);

        return redirect()->route('forum.chat');
    }

    public function hapusPesan($id)
    {
        $pesan = Pesan::findOrFail($id);

        // Pastikan pengguna yang ingin menghapus pesan adalah pemilik pesan atau memiliki hak akses
        if ($pesan->pengguna_id == Session::get('pengguna_id')) {
            $pesan->delete();
        }

        return redirect()->back();
    }

    public function editPesan($id)
    {
        $pesan = Pesan::findOrFail($id);

        // Pastikan pengguna yang ingin mengedit pesan adalah pemilik pesan atau memiliki hak akses
        if ($pesan->pengguna_id == Session::get('pengguna_id')) {
            return view('forum.edit', compact('pesan'));
        }

        return redirect()->back();
    }

    public function updatePesan(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string',
        ]);

        $pesan = Pesan::findOrFail($id);

        // Pastikan pengguna yang ingin mengupdate pesan adalah pemilik pesan atau memiliki hak akses
        if ($pesan->pengguna_id == Session::get('pengguna_id')) {
            $pesan->update([
                'isi_pesan' => $request->isi_pesan,
            ]);
        }

        return redirect()->route('forum.chat');
    }

    public function editReply($id)
    {
        $reply = Pesan::findOrFail($id);

        // Pastikan pengguna yang ingin mengedit reply adalah pemilik reply atau memiliki hak akses
        if ($reply->pengguna_id == Session::get('pengguna_id')) {
            return view('forum.edit_reply', compact('reply'));
        }

        return redirect()->back();
    }

    public function updateReply(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string',
        ]);

        $reply = Pesan::findOrFail($id);

        // Pastikan pengguna yang ingin mengupdate reply adalah pemilik reply atau memiliki hak akses
        if ($reply->pengguna_id == Session::get('pengguna_id')) {
            $reply->update([
                'isi_pesan' => $request->isi_pesan,
            ]);
        }

        return redirect()->route('forum.chat');
    }
}