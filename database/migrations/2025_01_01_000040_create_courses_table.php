<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('subject'); // nama mapel: Matematika, Bahasa Inggris, dll
            $table->enum('grade_level', ['X', 'XI', 'XII']);
            $table->enum('class_group', ['A', 'B', 'C']);

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->unique(['subject', 'grade_level', 'class_group'], 'courses_unique_subject_grade_class');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
