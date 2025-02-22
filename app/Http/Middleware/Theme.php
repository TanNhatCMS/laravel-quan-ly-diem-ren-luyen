<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Theme
{
    public function handle($request, Closure $next): mixed
    {
        // Set theme if exists
        if (Session::has('backpack.ui.view_namespace')) {
            Config::set('backpack.ui.view_namespace', Session::get('backpack.ui.view_namespace'));
        }

        // Set layout if exist in session — only for Tabler
        if (Session::get('backpack.ui.view_namespace') === 'tannhatcms.theme-tabler-lms::') {
            Config::set('tannhatcms.theme-tabler-lms.layout', Session::get('backpack.theme-tabler.layout') ?? config('tannhatcms.theme-tabler-lms.layout'));
        }

        return $next($request);
    }
}
