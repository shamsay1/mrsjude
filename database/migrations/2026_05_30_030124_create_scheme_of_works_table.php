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
        Schema::create('scheme_of_works', function (Blueprint $table) {
            $table->id();

    $table->foreignId('subject_id')
        ->constrained()
        ->onDelete('cascade');

    $table->string('academic_year');
    $table->string('term');

    $table->text('main_competence');
    $table->text('specific_competence');
    $table->text('learning_activity');
    $table->text('specific_activity');

    $table->string('month')->nullable();
    $table->integer('week')->nullable();
    $table->integer('period')->nullable();

    $table->text('teaching_method')->nullable();
    $table->text('learning_resource')->nullable();
    $table->text('assessment_tool')->nullable();
    $table->text('reference')->nullable();
    $table->text('remarks')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_of_works');
    }
};
