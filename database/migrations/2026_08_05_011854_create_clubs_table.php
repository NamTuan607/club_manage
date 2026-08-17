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
    Schema::create('clubs', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->string('short_name', 20)->nullable();
        $table->string('logo')->nullable();

        $table->text('description')->nullable();

        $table->string('email')->nullable();
        $table->string('phone',20)->nullable();

        $table->string('location')->nullable();

        $table->date('founding_date')->nullable();

        $table->string('advisor')->nullable();

        $table->string('president')->nullable();

        $table->integer('max_members')->default(100);

        $table->enum('status',[
            'active',
            'inactive'
        ])->default('active');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
