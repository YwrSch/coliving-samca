<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProprietarioOfertaController;
use App\Models\Oferta;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AlunoProfileController;
use App\Http\Controllers\AlunoDashboardController;
use App\Http\Controllers\ProprietarioDashboardController;


//FUNÇÕES
function aplicarFiltros(Request $request) {
    $query = Oferta::query();
    // Garante que a oferta esta ativa
    $query->where('ativa', true);

    // Filtros Básicos
    if ($request->filled('preco')) {
        switch ($request->preco) {
            case '1': $query->where('preco_mensal', '<=', 300); break;
            case '2': $query->whereBetween('preco_mensal', [301, 500]); break;
            case '3': $query->whereBetween('preco_mensal', [501, 700]); break;
            case '4': $query->where('preco_mensal', '>', 700); break;
        }
    }
    if ($request->filled('acomodacao')) {
        switch ($request->acomodacao) {
            case '1': $query->where('tipo_vaga', 'individual'); break;
            case '2': $query->where('tipo_vaga', 'compartilhado'); break;
            case '3': $query->where('tipo_imovel', 'republica'); break;
            case '4': $query->where('tipo_vaga', 'imovel_inteiro'); break;
        }
    }
    if ($request->has('garagem')) $query->whereJsonContains('comodidades', 'garagem');
    if ($request->has('servico')) $query->whereJsonContains('comodidades', 'servico');
    if ($request->has('mobiliado')) $query->whereJsonContains('comodidades', 'mobiliado');
    if ($request->has('cozinha')) $query->whereJsonContains('comodidades', 'cozinha');
    if ($request->has('pets')) $query->whereJsonContains('regras', 'pet');
    if ($request->has('fumar')) $query->whereJsonContains('regras', 'fumo');
    if ($request->has('silencio')) $query->whereJsonContains('regras', 'silencio');

    // Filtro de Distância (Haversine SQL)
    if ($request->filled('distancia') && $request->distancia != '4') {
        $lat = -5.654591768564729; $lng = -36.61251325403497; // UFERSA
        $km = match($request->distancia) { '1' => 1, '2' => 3, '3' => 5, default => 100 };
        $query->whereRaw("
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?
        ", [$lat, $lng, $lat, $km]);
    }

    return $query->with('proprietario')->latest()->get();
}

//ROTAS PÚBLICAS
Route::get('/', function (Request $request) {
    $ofertas = aplicarFiltros($request);

    $mapMarkers = $ofertas->map(function ($oferta) {
        return [
            'latlng' => [$oferta->latitude, $oferta->longitude],
            'titulo' => $oferta->titulo_anuncio,
            'preco' => number_format($oferta->preco_mensal, 2, ',', '.'),
            'foto' => $oferta->fotos[0] ?? null
        ];
    });

    return view('index', ['ofertas' => $ofertas, 'mapMarkers' => $mapMarkers->toJson()]);
});

//ROTAS DE AUTENTICAÇÃO
require __DIR__.'/auth.php'; 

//ROTAS PROTEGIDAS (CONTROLE DE PERFIL)
Route::get('/dashboard', function () {
    return Auth::user()->role == 'proprietario' 
        ? redirect()->route('proprietario.dashboard') 
        : redirect()->route('aluno.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//GRUPO DE ROTAS ESTUDANTE E PROPRIETÁRIO
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/messages/send', [MessageController::class, 'store'])
        ->name('messages.store');
    Route::get('/messages/history/{userId}', [MessageController::class, 'show'])
        ->name('messages.show');
    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');
});

//GRUPO DE ROTAS DO ESTUDANTE
Route::middleware(['auth', 'verified', 'role:estudante'])->group(function () {
    Route::get('/aluno/dashboard', [AlunoDashboardController::class, 'index'])
        ->name('aluno.dashboard');
    
    Route::get('/aluno/buscar-moradia', function (Request $request) {
        $ofertas = aplicarFiltros($request); 
        $mapMarkers = $ofertas->map(function ($oferta) {
            return [
                'latlng' => [$oferta->latitude, $oferta->longitude],
                'titulo' => $oferta->titulo_anuncio,
                'preco' => number_format($oferta->preco_mensal, 2, ',', '.'),
                'foto' => $oferta->fotos[0] ?? null
            ];
        });
        return view('buscar_moradia', ['ofertas' => $ofertas, 'mapMarkers' => $mapMarkers->toJson()]);
    })->name('aluno.buscar');

    Route::get('/aluno/mensagens', [MessageController::class, 'index'])
        ->name('aluno.mensagens');
    Route::get('/aluno/perfil', [AlunoProfileController::class, 'show'])
        ->name('aluno.perfil');
    Route::get('/aluno/perfil/editar', [AlunoProfileController::class, 'edit'])
        ->name('aluno.perfil.editar');
    Route::put('/aluno/perfil', [AlunoProfileController::class, 'update'])
        ->name('aluno.perfil.update');
});

//GRUPO DE ROTAS DO PROPRIETÁRIO
Route::middleware(['auth', 'verified', 'role:proprietario'])->group(function () {

    Route::get('/proprietario/dashboard', [ProprietarioDashboardController::class, 'index'])
        ->name('proprietario.dashboard');
    Route::get('/proprietario/publicar-oferta', [ProprietarioOfertaController::class, 'create'])
        ->name('proprietario.publicar');
    Route::post('/proprietario/publicar-oferta', [ProprietarioOfertaController::class, 'store'])
        ->name('proprietario.oferta.store');
    Route::get('/proprietario/gerenciar-propriedades', function () {
        $ofertas = Oferta::where('user_id', Auth::id())->latest()->get();
        return view('gerenciar_propriedades', ['ofertas' => $ofertas]);
    })->name('proprietario.gerenciar');
    Route::get('/proprietario/mensagens', [MessageController::class, 'index'])
        ->name('proprietario.mensagens');
    Route::get('/proprietario/oferta/{id}/editar', [ProprietarioOfertaController::class, 'edit'])
        ->name('oferta.edit');    
    Route::put('/proprietario/oferta/{id}', [ProprietarioOfertaController::class, 'update'])
        ->name('oferta.update');
    Route::patch('/proprietario/oferta/{id}/toggle', [ProprietarioOfertaController::class, 'toggleStatus'])
        ->name('oferta.toggle');
    Route::delete('/proprietario/oferta/{id}', [ProprietarioOfertaController::class, 'destroy'])
        ->name('oferta.destroy');
});