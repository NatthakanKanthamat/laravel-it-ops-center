<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high'])->default('Medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
           
            //เชื่อมโยงกับตาราง users ผ่าน user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ใครเป็นคนแจ้ง
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade'); // อุปกรณ์ชิ้นไหนที่เสีย
    
            $table->string('issue_image', 255)->nullable(); // เก็บชื่อไฟล์รูปอาการเสียที่ถ่ายส่งมา
            $table->text('admin_note')->nullable(); // สำหรับ IT บันทึกตอนซ่อมเสร็จ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
