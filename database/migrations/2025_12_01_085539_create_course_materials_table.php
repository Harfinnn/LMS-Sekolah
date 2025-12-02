<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->string('title');             // Bab 1: ... / Pertemuan 1: ...
            $table->integer('order')->default(1); // urutan bab/pertemuan

            $table->string('category');          // 'video' atau 'text'
            $table->string('video_url')->nullable(); // kalau video
            $table->text('content')->nullable();     // kalau teks
            $table->string('file_path')->nullable(); // PDF/PPT opsional

            $table->text('short_description')->nullable(); // ringkas bab
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_materials');
    }
}
