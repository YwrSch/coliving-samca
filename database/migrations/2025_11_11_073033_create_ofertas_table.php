<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('titulo_anuncio');
            $table->string('tipo_imovel');
            $table->string('bairro');
            $table->string('rua');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->json('fotos')->nullable()->after('resumo_regras');
            $table->string('tipo_vaga');
            $table->integer('num_vagas');
            $table->decimal('preco_mensal', 8, 2);
            $table->json('custos')->nullable();
            $table->json('comodidades')->nullable();
            $table->json('regras')->nullable(); 
            $table->text('resumo_regras')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};