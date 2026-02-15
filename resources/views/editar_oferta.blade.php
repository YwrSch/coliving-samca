<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Oferta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.navigation_proprietario')

    <main>
        <div class="container custom-container" style="margin-top: 40px;">
            <h4>Editar Oferta</h4>
            <div class="card-panel">
                <form action="{{ route('oferta.update', $oferta->id) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="titulo" name="titulo_anuncio" type="text" value="{{ $oferta->titulo_anuncio }}" required>
                            <label for="titulo">Título do Anúncio</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <input id="preco" name="preco_mensal" type="number" step="0.01" value="{{ $oferta->preco_mensal }}" required>
                            <label for="preco">Preço Mensal (R$)</label>
                        </div>
                        
                        <div class="input-field col s12 m4">
                            <input id="vagas" name="num_vagas" type="number" value="{{ $oferta->num_vagas }}" required>
                            <label for="vagas">Número de Vagas</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <select name="tipo_vaga" required>
                                <option value="" disabled>Escolha o tipo</option>
                                <option value="individual" {{ $oferta->tipo_vaga == 'individual' ? 'selected' : '' }}>Quarto Individual</option>
                                <option value="compartilhado" {{ $oferta->tipo_vaga == 'compartilhado' ? 'selected' : '' }}>Quarto Compartilhado</option>
                                <option value="republica" {{ $oferta->tipo_vaga == 'republica' ? 'selected' : '' }}>Vaga em República</option>
                                <option value="imovel_inteiro" {{ $oferta->tipo_vaga == 'imovel_inteiro' ? 'selected' : '' }}>Imóvel Inteiro</option>
                            </select>
                            <label>Tipo de Acomodação</label>
                        </div>

                        <div class="input-field col s12 m8">
                            <input id="rua" name="rua" type="text" value="{{ $oferta->rua }}">
                            <label for="rua">Rua</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="numero" name="numero" type="text" value="{{ $oferta->numero }}">
                            <label for="numero">Número</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="bairro" name="bairro" type="text" value="{{ $oferta->bairro }}">
                            <label for="bairro">Bairro</label>
                        </div>
                        
                        <div class="input-field col s12">
                            <textarea id="regras" name="resumo_regras" class="materialize-textarea">{{ $oferta->resumo_regras }}</textarea>
                            <label for="regras">Descrição / Regras</label>
                        </div>
                    </div>

                    <div class="center-align">
                        <a href="{{ route('proprietario.gerenciar') }}" class="btn-flat waves-effect red-text">Cancelar</a>
                        <button type="submit" class="btn waves-effect waves-light samca-btn">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.Sidenav.init(document.querySelectorAll('.sidenav'));
            M.updateTextFields(); 
            M.FormSelect.init(document.querySelectorAll('select'));
        });
    </script>
</body>
</html>