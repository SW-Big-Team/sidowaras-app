<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\NotificationService;
use App\Services\LogMonitorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService();
        });
        
        $this->app->singleton(LogMonitorService::class, function ($app) {
            return new LogMonitorService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => [
                'user' => fn () => Auth::user()
                    ? [
                        'id' => Auth::id(),
                        'name' => Auth::user()->name,
                        'role' => Auth::user()->role,
                    ]
                    : null,
            ],
        ]);

        // Share notifications to all Blade views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notificationService = app(NotificationService::class);
                $user = Auth::user();
                $role = $user->role->nama_role ?? 'Guest';
                
                $view->with([
                    'notifications' => $notificationService->getNotificationsForUser($user->id, $role, 10),
                    'unreadNotificationCount' => $notificationService->getUnreadCount($user->id, $role),
                ]);
            }
        });
    }
}

