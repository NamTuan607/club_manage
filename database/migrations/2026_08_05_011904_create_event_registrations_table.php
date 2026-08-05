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
    Schema::create('event_registrations', function (Blueprint $table) {

        $table->id();

        // Sự kiện
        $table->foreignId('event_id')
              ->constrained('events')
              ->cascadeOnDelete();

        // Sinh viên
        $table->foreignId('student_id')
              ->constrained('students')
              ->cascadeOnDelete();

        $table->timestamp('registered_at');

        $table->enum('status',[
            'registered',
            'cancelled'
        ])->default('registered');

        $table->timestamps();

        // Không đăng ký trùng
        $table->unique(['event_id','student_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
