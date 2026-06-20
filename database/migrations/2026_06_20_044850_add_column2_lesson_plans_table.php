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
        Schema::table('lesson_plans', function (Blueprint $table) {
        $table->foreignId('class_room_id')->nullable()->after('subject_id')->constrained('class_rooms')->onDelete('cascade');
        $table->foreignId('school_id')->nullable()->after('class_room_id')->constrained('schools')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
