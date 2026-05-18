<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaintenancesController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// นำเข้า Model เพื่อใช้ดึงตัวเลขสรุปหน้า Dashboard
use App\Models\Asset;
use App\Models\Maintenances;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // หน้า Dashboard พร้อม Logic ส่งตัวเลขสรุป
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // ถ้าเป็น Admin: ดึงข้อมูลทั้งหมดในระบบ
            $assetsCount = Asset::count();
            $pendingMaintenances = Maintenances::where('status', 'pending')->count();
        } else {
            // ถ้าเป็น User: ดึงเฉพาะข้อมูลที่ตัวเองเกี่ยวข้อง (สมมติว่าในตารางมี user_id)
            $assetsCount = Asset::where('user_id', $user->id)->count();
            $pendingMaintenances = Maintenances::where('user_id', $user->id)
                                              ->where('status', 'pending')
                                              ->count();
        }

        return view('dashboard', compact('assetsCount', 'pendingMaintenances'));
    })->name('dashboard');

    // จัดการ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ส่วนของ IT-Ops Center ---
    
    // จัดการพนักงาน (ใส่ Middleware เพิ่มเพื่อความปลอดภัย ไม่ให้ User แอบพิมพ์ URL เข้ามา)
    Route::resource('users', UserController::class)->middleware('can:admin-only');
    
    // จัดการอุปกรณ์
    Route::resource('assets', AssetController::class);
    
    // รายการแจ้งซ่อม
    Route::resource('maintenances', MaintenancesController::class);
});

require __DIR__.'/auth.php';