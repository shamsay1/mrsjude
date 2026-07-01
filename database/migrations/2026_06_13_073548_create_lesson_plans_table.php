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
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();

    $table->foreignId('subject_id')
        ->constrained('subjects')
        ->onDelete('cascade');

    $table->foreignId('topic_id')
      ->constrained('topics')
      ->cascadeOnDelete();

$table->foreignId('sub_topic_id')
      ->constrained('sub_topics')
      ->cascadeOnDelete();

    $table->text('objectives');

    $table->text('teaching_methods');

    $table->text('teaching_materials');

    $table->date('lesson_date');

    $table->string('status')->default('pending');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
