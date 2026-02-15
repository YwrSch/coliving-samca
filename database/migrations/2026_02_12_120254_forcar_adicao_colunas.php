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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'curso')) $table->string('curso')->nullable();
            if (!Schema::hasColumn('users', 'ingresso')) $table->string('ingresso')->nullable();
            if (!Schema::hasColumn('users', 'conclusao')) $table->string('conclusao')->nullable();
            if (!Schema::hasColumn('users', 'genero')) $table->string('genero')->nullable();
            if (!Schema::hasColumn('users', 'data_nascimento')) $table->date('data_nascimento')->nullable();
            if (!Schema::hasColumn('users', 'fuma')) $table->boolean('fuma')->default(false);
            if (!Schema::hasColumn('users', 'pets')) $table->boolean('pets')->default(false);
            if (!Schema::hasColumn('users', 'silencio')) $table->boolean('silencio')->default(false);
            if (!Schema::hasColumn('users', 'visitas')) $table->boolean('visitas')->default(false);
            if (!Schema::hasColumn('users', 'vegetariano')) $table->boolean('vegetariano')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
