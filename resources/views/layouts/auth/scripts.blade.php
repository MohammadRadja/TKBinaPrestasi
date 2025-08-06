<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('asset/js/script.js') }}"></script>
@yield('scripts')
<script>
    $(document).ready(function() {
        $('.sidebar-item').removeClass('active');
        var currentUrl = window.location.href;
        $('.sidebar-link').each(function() {
            if ($(this).attr('href') === currentUrl) {
                $(this).closest('.sidebar-item').addClass('active');
            }
        });
    });
</script>
