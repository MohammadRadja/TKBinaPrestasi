<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar shadow-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('/asset/img/Logo.jpg') }}" alt="" height="48" />
            <span>TKIT BINA PRESTASI</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-right" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/profil">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/program">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/kontak">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/login">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- penutup navbar -->
<style>
    .navbar {
        background-color: #3F417E;
    }
    .custom-navbar .navbar-brand span {
        color: white;
    }
    .custom-navbar .navbar-nav .nav-link {
        color: white;
    }
    .custom-navbar .navbar-nav .nav-link:hover {
        color: #FDEE1D;
    }
</style>