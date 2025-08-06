<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">

                {{-- 🔔 NOTIFIKASI --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if (isset($notifikasi) && $notifikasi->count() > 0)
                            <span class="badge bg-danger">{{ $notifikasi->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                        @forelse($notifikasi as $n)
                            <li>
                                <a class="dropdown-item" href="#">
                                    {{ $n->data['message'] ?? 'Notifikasi baru' }}
                                    <small class="text-muted d-block">{{ $n->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item">Tidak ada notifikasi</span></li>
                        @endforelse
                    </ul>
                </li>

                {{-- ⚙️ PENGATURAN / PROFIL --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                        @if ($role === 'siswa')
                            <li><a class="dropdown-item" href="{{ route('siswa.profil') }}"><i class="fa fa-user"></i>
                                    Profil</a></li>
                        @elseif ($role === 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.profil') }}"><i class="fa fa-user"></i>
                                    Profil</a></li>
                        @elseif ($role === 'guru')
                            <li><a class="dropdown-item" href="{{ route('guru.profil') }}"><i class="fa fa-user"></i>
                                    Profil</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i> Log out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
