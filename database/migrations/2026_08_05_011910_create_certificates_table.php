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
    Schema::create('certificates', function (Blueprint $table) {

        $table->id();

        // Điểm hoạt động
        $table->foreignId('student_point_id')
              ->constrained('student_points')
              ->cascadeOnDelete();

        // Mã chứng nhận
        $table->string('certificate_code')->unique();

        // Ngày cấp
        $table->timestamp('issued_at');

        $table->enum('status',[
            'valid',
            'revoked'
        ])->default('valid');

        $table->timestamps();

        $table->unique('student_point_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
