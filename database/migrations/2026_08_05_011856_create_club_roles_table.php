<?php
# Vai trò: Migration tạo bảng chức vụ theo từng câu lạc bộ.

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
    Schema::create('club_roles', function (Blueprint $table) {

        $table->id();
        $table->foreignId('club_id')->constrained()->cascadeOnDelete();

        $table->string('role_name');
        $table->text('description')->nullable();
        $table->timestamps();

        $table->unique(['club_id', 'role_name']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_roles');
    }
};
