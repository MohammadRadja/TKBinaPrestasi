<footer class="bg-footer text-white">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg col-md-6">
                <div class="ftco-footer-widget">
                    <h2 class="logo d-flex align-items-center">
                        <a href="index.html" class="d-flex align-items-center">
                            <div class="icon">
                                <img src="{{ asset('/asset/img/Logo.jpg') }}" alt="logo" class="logo" loading="lazy" />
                            </div>
                        </a>
                    </h2>
                </div>
            </div>

             <!-- Quick Links -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-white text-decoration-none d-block mb-2"><i class="fas fa-angle-right me-2"></i>Beranda</a></li>
                    <li><a href="/profil" class="text-white text-decoration-none d-block mb-2"><i class="fas fa-angle-right me-2"></i>Tentang Kami</a></li>
                    <li><a href="/program" class="text-white text-decoration-none d-block mb-2"><i class="fas fa-angle-right me-2"></i>Program</a></li>
                    <li><a href="/kontak" class="text-white text-decoration-none d-block"><i class="fas fa-angle-right me-2"></i>Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Program -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Program</h5>
                <ul class="list-unstyled">
                    @foreach(['Silat','Melukis','Menari','Komputer','Tahfidz','Manasik Haji'] as $prog)
                        <li><a href="/program" class="text-white text-decoration-none d-block mb-2"><i class="fas fa-angle-right me-2"></i>{{ $prog }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-md-3">
                <h5 class="mb-3">Kontak</h5>
                <p>
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:tkitbinaprestasi@gmail.com">Email: tkitbinaprestasi@gmail.com</a>
                </p>
                <p>
                    <i class="fas fa-phone me-2"></i>
                    <a href="tel:+6285765549259">Telepon: +62 857-6554-9259</a>
                </p>
                <a href="https://www.facebook.com/share/nm7a3SsewkULnfoX/?mibextid=qi2Omg" target="_blank"
                    title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kelasbinaprestasi?igsh=b3M3NXN4MHRha3l4" target="_blank"
                    title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@tutymunawaroh7767?si=rkrmZ1Du5fIcoeOj" target="_blank" title="YouTube"><i
                        class="fab fa-youtube"></i></a>
                <a href="http://wa.me/6285765549259" target="_blank" title="WhatsApp"><i
                        class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid bg-footer-bottom py-3">
        <div class="text-center">
            <p class="mb-0 text-footer-bottom">&copy; 2024 TKIT Bina Prestasi. All Rights Reserved.</p>
        </div>
    </div>
</footer>