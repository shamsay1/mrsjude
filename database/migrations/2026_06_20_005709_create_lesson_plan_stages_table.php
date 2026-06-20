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
        Schema::create('lesson_plan_stages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lesson_plan_id')
                  ->constrained('lesson_plans')
                  ->cascadeOnDelete();

            $table->string('stage_name'); 

            $table->integer('minutes')->nullable();

            $table->longText('teaching_activities')->nullable();

            $table->longText('learning_activities')->nullable();

            $table->longText('assessment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plan_stages');
    }
};
