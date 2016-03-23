<?php

namespace App\Http\Middleware;

use Closure;
use App\Theme;
use File;
use Log;

class RegisterThemeEventListener
{
    /**
     * Handle an incoming request.
     * Get the current theme from session and fetch theme from DB. 
     * Load the theme's functions.php file in order to register event listeners.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $theme_id = session('theme-id');

        if ($theme_id != '' && $theme_id != null) {

            $theme = Theme::where('id', $theme_id)->first(); 

            if ($theme != null && $theme->status == Theme::STATUS_ACTIVE && File::exists($theme->root_dir . '/' . Theme::FUNCTIONS_FILE)) {
                require $theme->root_dir . '/' . Theme::FUNCTIONS_FILE;
            } 
        }
        
        return $next($request);
    }
}
