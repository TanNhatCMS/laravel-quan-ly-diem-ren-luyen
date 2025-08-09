{{-- Load jQuery first as it's required by other scripts --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

{{-- Load Bootstrap bundle --}}
<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

{{-- Load Noty notification library --}}
<script src="{{ asset('vendor/noty/noty.min.js') }}"></script>

{{-- Load SweetAlert2 --}}
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

{{-- Load Tabler JS from local assets instead of CDN --}}
<script src="{{ asset('vendor/tabler/tabler.min.js') }}"></script>

{{-- Load local theme scripts --}}
@basset(base_path('vendor/tannhatcms/theme-tabler-lms/resources/assets/js/tabler.js'))