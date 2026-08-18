<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Supports databases migrated before the original check-in migration was corrected.
        if (Schema::hasTable('checkin_logs')) {
            Schema::table('checkin_logs', function (Blueprint $table) {
                $table->enum('status', ['pending', 'approved'])->default('pending')->change();
            });
        }
    }

    public function down(): void
    {
        // The application only uses the new approval states.
    }
};
