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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained("students")->onDelete("cascade");
            $table->foreignId('subject_id')->constrained("subjects")->onDelete("cascade");
            $table->integer('classwork1')->nullable();
            $table->integer('classwork2')->nullable();
            $table->integer('classwork3')->nullable();
            $table->integer('classwork4')->nullable();
            $table->integer('classwork5')->nullable();
            $table->integer('classwork6')->nullable();
            $table->integer('classwork7')->nullable();
            $table->integer('classwork8')->nullable();
            $table->integer('classwork9')->nullable();
            $table->integer('classwork10')->nullable();

            $table->integer('homework1')->nullable();
            $table->integer('homework2')->nullable();
            $table->integer('homework3')->nullable();
            $table->integer('homework4')->nullable();
            $table->integer('homework5')->nullable();

            $table->integer('topictest1')->nullable();
            $table->integer('topictest2')->nullable();
            $table->integer('topictest3')->nullable();

            $table->integer('terminal_exam')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
