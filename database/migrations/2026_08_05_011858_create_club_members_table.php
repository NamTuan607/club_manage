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
    Schema::create('club_members', function (Blueprint $table) {

        $table->id();

        // CLB
        $table->foreignId('club_id')
              ->constrained('clubs')
              ->cascadeOnDelete();

        // Sinh viên
        $table->foreignId('student_id')
              ->constrained('students')
              ->cascadeOnDelete();

        // Vai trò trong CLB
        $table->foreignId('club_role_id')
              ->constrained('club_roles')
              ->cascadeOnDelete();

        // Ngày tham gia
        $table->date('join_date');

        // Trạng thái
        $table->enum('status',[
            'active',
            'inactive'
        ])->default('active');

        $table->timestamps();

        // Không được tham gia 1 CLB 2 lần
        $table->unique(['club_id','student_id']);
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
