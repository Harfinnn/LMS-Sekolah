<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->string('day'); // Senin, Selasa, Rabu, Kamis, Jumat
            $table->string('subject');

            $table->time('start_time');
            $table->time('end_time');

            $table->enum('grade_level', ['X', 'XI', 'XII']);
            $table->enum('class_group', ['A', 'B', 'C']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
