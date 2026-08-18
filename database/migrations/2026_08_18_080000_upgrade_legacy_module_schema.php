<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds fields missing from the initial group migrations. On a fresh
     * database the original migrations already contain these fields.
     */
    public function up(): void
    {
        if (Schema::hasTable('club_roles') && !Schema::hasColumn('club_roles', 'club_id')) {
            Schema::table('club_roles', function (Blueprint $table) {
                $table->foreignId('club_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('event_categories')) {
            if (!Schema::hasColumn('event_categories', 'max_points')) {
                Schema::table('event_categories', function (Blueprint $table) {
                    $table->unsignedInteger('max_points')->default(100)->after('description');
                });
            }

            if (!Schema::hasColumn('event_categories', 'status')) {
                Schema::table('event_categories', function (Blueprint $table) {
                    $table->enum('status', ['active', 'inactive'])->default('active')->after('max_points');
                });
            }
        }

        if (Schema::hasTable('student_points') && !Schema::hasColumn('student_points', 'student_id')) {
            Schema::table('student_points', function (Blueprint $table) {
                $table->foreignId('student_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('rule_id')->nullable()->constrained('activity_point_rules')->cascadeOnDelete();
                $table->integer('points')->default(0);
                $table->timestamp('awarded_at')->nullable();
            });
        }

        if (Schema::hasTable('activity_point_rules') && !Schema::hasColumn('activity_point_rules', 'event_name')) {
            Schema::table('activity_point_rules', function (Blueprint $table) {
                $table->string('event_name')->nullable()->after('event_category_id');
            });
        }
    }

    public function down(): void
    {
        // Kept intentionally empty to avoid removing data from older databases.
    }
};
