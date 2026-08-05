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
    Schema::create('checkin_logs', function (Blueprint $table) {

        $table->id();

        // Phiếu đăng ký
        $table->foreignId('registration_id')
              ->constrained('event_registrations')
              ->cascadeOnDelete();

        $table->timestamp('checkin_time');

        $table->enum('status',[
            'checked_in'
        ])->default('checked_in');

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
