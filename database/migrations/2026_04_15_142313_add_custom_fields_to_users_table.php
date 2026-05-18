<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
   Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username'); // ต้องเป็น username ไม่ใช่ name
        $table->string('email')->unique();
        $table->string('password');
        $table->string('department')->nullable(); // เพิ่มตามที่คุณต้องการ
        $table->string('role')->default('user');   // เพิ่มตามที่คุณต้องการ
        $table->timestamps(); // ตัวนี้จะสร้าง created_at กับ updated_at ให้เอง
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['department', 'role']);
    });
    }
};
