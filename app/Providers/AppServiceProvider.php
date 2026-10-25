<?php

namespace App\Providers;

use App\Support\SystemNotifications;
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
        // Notifikasi pada layout admin di isi dari data nyata (bukan dummy)
        View::composer('layouts.admin', function ($view) {
            $view->with('notifikasiTerbaru', SystemNotifications::latest(6));
        });

        View::composer('layouts.siswa', function ($view) {
            $user = auth()->user();
            $notif = $user ? SystemNotifications::forSiswa($user, 8) : [];
            $unreadCount = count(array_filter($notif, fn($n) => empty($n['is_read'])));
            $view->with([
                'notifikasiTerbaru' => $notif,
                'notifUnreadCount'  => $unreadCount,
            ]);
        });
    }
}
