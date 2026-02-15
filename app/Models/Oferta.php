<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo_anuncio',
        'tipo_imovel',
        'bairro',
        'rua',
        'numero',
        'complemento',
        'latitude',
        'longitude',
        'fotos',
        'tipo_vaga',
        'num_vagas',
        'preco_mensal',
        'custos',
        'comodidades',
        'regras',
        'resumo_regras',
    ];

    protected $casts = [
        'fotos' => 'array',
        'custos' => 'array',
        'comodidades' => 'array',
        'regras' => 'array',
    ];

    public function proprietario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}