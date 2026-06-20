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
        Schema::create('reports', function (Blueprint $table) {
            // id BIGINT PRIMARY KEY AUTO_INCREMENT
            $table->id(); 
            
            // Foreign keys (Zinawekwa kama bigint unsigned kwa usalama wa uhusiano wa tables)
            $table->foreignId('supervisor_id')->constrained('system_users')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('class_room_id')->constrained('class_rooms')->onDelete('cascade');
            
            // Data zingine
            $table->string('title', 255)->nullable(); // Nimeweka nullable kama si lazima
            $table->string('report_type', 100)->nullable();
            $table->date('report_date')->nullable();
            
            $table->decimal('average_score', 5, 2)->nullable();
            $table->decimal('pass_rate', 5, 2)->nullable();
            
            $table->integer('total_students')->nullable();
            $table->integer('passed_students')->nullable();
            $table->integer('failed_students')->nullable();
            
            $table->text('comments')->nullable();
            $table->enum('status', ['pending', 'reviewed'])->default('pending');
            
            // created_at na updated_at TIMESTAMP NULL
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};