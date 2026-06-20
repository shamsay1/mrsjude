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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')
                ->constrained('system_users')
                ->onDelete('cascade');
            $table->foreignId('school_id')
                ->constrained('schools')
                ->onDelete('cascade');
            $table->text('instruction');
            $table->date('inspection_date');
            $table->string("status")->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
