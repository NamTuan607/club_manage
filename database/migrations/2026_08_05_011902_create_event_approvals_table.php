<?php
# Vai trò: Migration tạo bảng lịch sử phê duyệt sự kiện.

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
    Schema::create('event_approvals', function (Blueprint $table) {

        $table->id();

        // Sự kiện
        $table->foreignId('event_id')
              ->constrained('events')
              ->cascadeOnDelete();

        // Người duyệt
        $table->foreignId('approved_by')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->enum('status',[
            'approved',
            'rejected'
        ]);

        $table->text('note')->nullable();

        $table->timestamp('approved_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_approvals');
    }
};
