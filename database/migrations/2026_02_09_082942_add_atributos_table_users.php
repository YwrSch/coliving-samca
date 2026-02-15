<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ingresso')->nullable();
            $table->string('conclusao')->nullable();
            $table->boolean('fuma')->default(false);
            $table->boolean('pets')->default(false);
            $table->boolean('silencio')->default(false);
            $table->boolean('visitas')->default(false);
            $table->boolean('vegetariano')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ingresso', 'conclusao', 'fuma', 'pets', 'silencio', 'visitas', 'vegetariano']);
        });
    }
};
