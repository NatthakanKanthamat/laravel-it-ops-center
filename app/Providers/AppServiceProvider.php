<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//เพิ่มเข้ามาเพื่อให้เรียกใช้ Gate และ User แบบนี้ใช่ไหม
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        // กำหนด Gate สำหรับแอดมิน
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
