<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
@if (backpack_theme_config('meta_robots_content'))
<meta name="robots" content="{{ backpack_theme_config('meta_robots_content', 'noindex, nofollow') }}">
@endif

@includeWhen(view()->exists('vendor.backpack.ui.inc.header_metas'), 'vendor.backpack.ui.inc.header_metas')

<meta name="csrf-token" content="{{ csrf_token() }}"/> {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
<title>{{ isset($title) ? $title.' :: '.backpack_theme_config('project_name') : backpack_theme_config('project_name') }}</title>

@yield('before_styles')
@stack('before_styles')

{{-- OVERRIDE: Load theme styles first (includes Tabler and dependencies) --}}
@include(backpack_view('inc.theme_styles'))

{{-- Then load Backpack styles --}}
@include(backpack_view('inc.styles'))

{{-- Finally load Vite assets for custom CSS/JS (will override if needed) --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

@yield('after_styles')
@stack('after_styles')