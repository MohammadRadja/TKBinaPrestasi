<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">TKIT BINA PRESTASI</span>
        </a>

        <ul class="sidebar-nav">
            @if (Session::has('pengguna_id'))
                @php
                    $role = App\Models\Pengguna::find(Session::get('pengguna_id'))->role;
                @endphp

                {{-- ================= SIDEBAR SISWA ================= --}}
                @if ($role === 'siswa')
                    <li class="sidebar-header">Menu Utama</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('siswa.dashboard') }}"><i
                                class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="sidebar-item"><a class="sidebar-link"
                            href="{{ route('siswa.biodata.index', Session::get('pengguna_id')) }}"><i
                                class="fa fa-user"></i>
                            Biodata</a></li>

                    <li class="sidebar-header">Akademik</li>
                    <li class="sidebar-item"><a class="sidebar-link"
                            href="{{ route('siswa.jadwal.index', Session::get('pengguna_id')) }}"><i
                                class="fa fa-calendar"></i> Jadwal Akademik</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('siswa.pembayaran.index') }}"><i
                                class="fa fa-credit-card"></i>
                            Pembayaran</a></li>

                    <li class="sidebar-header">Lainnya</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('forum.chat') }}"><i
                                class="fa fa-comments"></i> Forum Chat</a></li>

                    {{-- ================= SIDEBAR ADMIN ================= --}}
                @elseif ($role === 'admin')
                    <li class="sidebar-header">Menu Utama</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.dashboard') }}"><i
                                class="fa fa-tachometer-alt"></i> Dashboard</a></li>

                    <li class="sidebar-header">Manajemen Data</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.mading.index') }}"><i
                                class="fa fa-bullhorn"></i> Pemberitahuan</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.siswa.index') }}"><i
                                class="fa fa-users"></i> Data Siswa</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.guru.index') }}"><i
                                class="fa fa-chalkboard-teacher"></i> Data Guru</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.kelas.index') }}"><i
                                class="fa fa-chalkboard"></i> Data Kelas</a></li>

                    <li class="sidebar-header">Akademik</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.pembayaran.index') }}"><i
                                class="fa fa-credit-card"></i>
                            Pembayaran</a></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.absensi.index') }}">
                            <i class="fa fa-calendar-check"></i>
                            <span>Absensi Siswa</span>
                        </a>
                    </li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.nilai.index') }}"><i
                                class="fa fa-chart-line"></i> Nilai Siswa</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.aktivitas.index') }}"><i
                                class="fa fa-running"></i> Aktivitas Harian</a></li>

                    <li class="sidebar-header">Lainnya</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('forum.chat') }}"><i
                                class="fa fa-comments"></i> Forum Chat</a></li>

                    {{-- ================= SIDEBAR GURU ================= --}}
                @elseif ($role === 'guru')
                    <li class="sidebar-header">Menu Utama</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('guru.dashboard') }}"><i
                                class="fa fa-tachometer-alt"></i> Dashboard</a></li>

                    <li class="sidebar-header">Akademik</li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('guru.absensi.index') }}"><i
                                class="fa fa-chart-line"></i>
                            Absensi Siswa</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('guru.nilai.index') }}"><i
                                class="fa fa-chart-line"></i> Nilai Siswa</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('guru.aktivitas.index') }}"><i
                                class="fa fa-running"></i> Aktivitas Harian</a></li>
                @endif
            @endif
        </ul>
    </div>
</nav>

<style>
    .sidebar {
        background-color: #343a40;
        color: #fff;
    }

    .sidebar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        padding: 1rem;
        display: block;
        text-align: center;
        color: #fff;
    }

    .sidebar-header {
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: bold;
        padding: 0.75rem 1rem;
        color: #ced4da;
        border-top: 1px solid #495057;
    }

    .sidebar-nav {
        padding: 0;
    }

    .sidebar-item {
        list-style: none;
    }

    .sidebar-link {
        color: #adb5bd;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .sidebar-link:hover {
        background-color: #495057;
        color: #fff;
    }

    .sidebar-link i {
        width: 20px;
        text-align: center;
        margin-right: 0.5rem;
    }

    .sidebar .active>.sidebar-link {
        background-color: #007bff;
        color: #fff;
    }
</style>
