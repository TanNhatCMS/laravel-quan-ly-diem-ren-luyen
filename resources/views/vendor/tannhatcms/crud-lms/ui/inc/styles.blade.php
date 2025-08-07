{{-- Load local assets instead of CDN --}}
<link rel="stylesheet" href="{{ asset('vendor/animate-css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/noty/noty.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/line-awesome/line-awesome.min.css') }}">

{{-- Load local CRUD styles --}}
@basset(base_path('vendor/tannhatcms/crud-lms/src/resources/assets/css/common.css'))

@if (backpack_theme_config('styles') && count(backpack_theme_config('styles')))
    @foreach (backpack_theme_config('styles') as $path)
        @if(is_array($path))
            @basset(...$path)
        @else
            @basset($path)
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_styles') && count(backpack_theme_config('mix_styles')))
    @foreach (backpack_theme_config('mix_styles') as $path => $manifest)
        <link rel="stylesheet" type="text/css" href="{{ mix($path, $manifest) }}">
    @endforeach
@endif

@if (backpack_theme_config('vite_styles') && count(backpack_theme_config('vite_styles')))
    @vite(backpack_theme_config('vite_styles'))
@endif