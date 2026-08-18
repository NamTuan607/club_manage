<?php
# Vai trò: Migration tạo bảng thành viên câu lạc bộ.

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
    Schema::create('club_members', function (Blueprint $table) {

    $table->id();

    $table->foreignId('club_id')->constrained()->cascadeOnDelete();

    $table->foreignId('student_id')->constrained()->cascadeOnDelete();

    $table->foreignId('club_role_id')->constrained('club_roles');

    $table->date('join_date');

    $table->date('leave_date')->nullable();

    $table->enum('status',[
        'active',
        'inactive',
        'pending'
    ])->default('active');

    $table->string('academic_year')->nullable();

    $table->text('note')->nullable();

    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_members');
    }
};
