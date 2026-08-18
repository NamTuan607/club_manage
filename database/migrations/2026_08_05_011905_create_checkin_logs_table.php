<?php
# Vai trò: Migration tạo bảng check-in với trạng thái chờ duyệt hoặc đã duyệt.

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
    Schema::create('checkin_logs', function (Blueprint $table) {

        $table->id();

        // Phiếu đăng ký
        $table->foreignId('registration_id')
              ->constrained('event_registrations')
              ->cascadeOnDelete();

        $table->timestamp('checkin_time');

        // Check-in is created first, then an administrator approves it to award points.
        $table->enum('status', ['pending', 'approved'])->default('pending');

        $table->timestamps();

        // Một phiếu chỉ checkin 1 lần
        $table->unique('registration_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkin_logs');
    }
};
