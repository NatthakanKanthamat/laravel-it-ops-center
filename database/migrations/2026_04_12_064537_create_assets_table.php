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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag', 100)->unique();
            $table->string('name', 255);
            $table->enum('category', ['PC', 'Laptop', 'Monitor'])->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('serial_number', 255)->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available');
            
            //เชื่อมโยงกับตาราง users ผ่าน user_id เพื่อบอกว่าใครเป็นเจ้าของอุปกรณ์ชิ้นนี้
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('asset_image')->nullable();  // เก็บชื่อไฟล์รูปอุปกรณ์ที่ถ่ายส่งมา
            $table->text('spec_details')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
