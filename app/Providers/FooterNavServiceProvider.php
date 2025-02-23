<?php

namespace App\Providers;

use App\Models\Layout;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class FooterNavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $layoutdata = Layout::all();

        // Organize data
        $footerContacts = $layoutdata->where('type', 'contact');
        $footerLocations = $layoutdata->where('type', 'location');
        $tiktok = $layoutdata->where('type', 'social_media')
            ->where('key', 'tiktok')
            ->sortByDesc('created_at')
            ->first();

        $instagram = $layoutdata->where('type', 'social_media')
            ->where('key', 'instagram')
            ->sortByDesc('created_at')
            ->first();

        $facebook = $layoutdata->where('type', 'social_media')
            ->where('key', 'facebook')
            ->sortByDesc('created_at')
            ->first();

        $footerLogo = $layoutdata->where('type', 'logo')
            ->where('key', 'footer')
            ->sortByDesc('created_at')
            ->first();

        $Navlogo = $layoutdata->where('type', 'logo')
            ->where('key', 'nav')
            ->sortByDesc('created_at')
            ->first();
       
            
        View::share([
            'footerContacts' => $footerContacts,
            'footerLocations' => $footerLocations,
            'tiktok' => $tiktok,
            'instagram' => $instagram,
            'facebook' => $facebook,
            'footerLogo' => $footerLogo,
            'navLogo' => $Navlogo,
        ]);
    }
}
