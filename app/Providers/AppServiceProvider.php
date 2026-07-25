<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('siteSettings', [
                    'site_name' => Setting::get('site_name', 'KKN Taman Sari 2026'),
                    'site_tagline' => Setting::get('site_tagline', 'Sistem Dokumentasi & Monitoring KKN'),
                    'about' => Setting::get('about', ''),
                    'location' => Setting::get('location', 'Desa Taman Sari'),
                    'contact_email' => Setting::get('contact_email', ''),
                    'contact_phone' => Setting::get('contact_phone', ''),
                    'instagram' => Setting::get('instagram', ''),
                ]);
            } else {
                $view->with('siteSettings', [
                    'site_name' => 'KKN Taman Sari 2026',
                    'site_tagline' => 'Sistem Dokumentasi & Monitoring KKN',
                    'about' => '',
                    'location' => 'Desa Taman Sari',
                    'contact_email' => '',
                    'contact_phone' => '',
                    'instagram' => '',
                ]);
            }
        });
    }
}
