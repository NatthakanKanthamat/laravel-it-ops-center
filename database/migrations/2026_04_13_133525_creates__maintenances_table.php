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
        Schema::create('maintenances', function (Blueprint $table) {
        $table->id();
        // เชื่อมกับตาราง Asset (ต้องรู้ว่าเครื่องไหนเสีย)
        $table->foreignId('asset_id')->constrained()->onDelete('cascade');
        // ใครเป็นคนแจ้ง (ดึงจากตาราง User ที่คุณเพิ่งสร้าง)
        $table->foreignId('user_id')->constrained(); 
        
        $table->text('description'); // อาการเสีย
        $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium'); // ความด่วน
        $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Canceled'])->default('Pending');// สถานะการซ่อม
        
        $table->text('repair_notes')->nullable(); // บันทึกจากช่าง (ซ่อมอะไรไปบ้าง)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
