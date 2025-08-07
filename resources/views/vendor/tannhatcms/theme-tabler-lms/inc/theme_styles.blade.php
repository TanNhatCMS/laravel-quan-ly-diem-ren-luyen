{{-- 
    we use a render blocking script in <head> to force the theme attribute to be in the document before it renders 
    avoiding white flicks when for example, using the dark color mode.
--}}
<script>document.documentElement.setAttribute("data-bs-theme", localStorage.colorMode ?? 'light');</script>

{{-- Load Tabler CSS from local assets instead of CDN --}}
<link rel="stylesheet" href="{{ asset('vendor/tabler/tabler.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/noty/noty.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">

{{-- Load local theme styles --}}
@basset(base_path('vendor/tannhatcms/theme-tabler-lms/resources/assets/css/style.css'))