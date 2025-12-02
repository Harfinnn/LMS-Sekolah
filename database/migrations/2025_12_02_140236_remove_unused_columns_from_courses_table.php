<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Hapus kolom bila masih ada
            if (Schema::hasColumn('courses', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('courses', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Bisa ditambahkan kembali saat rollback
            if (!Schema::hasColumn('courses', 'title')) {
                $table->string('title')->nullable();
            }

            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }
};
