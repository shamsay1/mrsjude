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
        Schema::create('daily_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')
                ->constrained('system_users')
                ->onDelete('cascade');
            $table->foreignId('school_id')
                ->constrained('schools')
                ->onDelete('cascade');
                $table->foreignId('subject_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('date');
            $table->string('period');
            $table->text('main_topic');
            $table->text('work_done_by_teacher');
            $table->text('work_done_by_student');
            $table->text('remarks')->nullable();
            $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_recordings');
    }
};
