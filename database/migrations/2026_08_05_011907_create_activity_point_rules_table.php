<?php
# Vai trò: Migration tạo bảng quy tắc tự động cộng điểm hoạt động.

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
    Schema::create('activity_point_rules', function (Blueprint $table) {

        $table->id();

        $table->foreignId('event_category_id')
              ->constrained('event_categories')
              ->cascadeOnDelete();

        // Exact event title is optional. When present it takes priority over
        // category rules while approving a check-in.
        $table->string('event_name')->nullable();

        $table->integer('points');

        $table->text('description')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_point_rules');
    }
};
