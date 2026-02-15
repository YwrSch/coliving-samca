<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Propriedades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.navigation_proprietario')

    <main>
        <div class="container custom-container" style="margin-top: 40px;">
            
            @if(session('success'))
                <div class="card-panel green lighten-4 green-text text-darken-4" style="padding: 10px;">
                    <i class="material-icons left">check</i> {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col s12">
                    <h4>Gerenciar Minhas Propriedades</h4>
                    <p class="grey-text">Gerencie a visibilidade e edite suas ofertas.</p>
                    <div class="divider"></div>
                </div>
                
                <div class="col s12" style="margin-top: 20px;">
                    <a href="{{ route('proprietario.publicar') }}" class="waves-effect waves-light btn samca-btn right">
                        <i class="material-icons left">add</i> Nova Publicação
                    </a>
                    <h5>{{ $ofertas->count() }} Ofertas Encontradas</h5>
                </div>
                
                <div class="col s12">
                    <ul class="collapsible popout">
                        @forelse($ofertas as $oferta)
                        <li class="{{ session('active_id') == $oferta->id ? 'active' : '' }}">
                            <div class="collapsible-header">
                                <i class="material-icons samca-color-text">home</i>
                                <span class="title" style="flex-grow: 1;">
                                    <b>{{ $oferta->titulo_anuncio }}</b>
                                </span>
                                
                                @if($oferta->ativa)
                                    <span class="new badge green" data-badge-caption="Ativo"></span>
                                @else
                                    <span class="new badge grey" data-badge-caption="Pausado"></span>
                                @endif
                                
                                <span class="badge grey-text">
                                    R$ {{ number_format($oferta->preco_mensal, 2, ',', '.') }}
                                </span>
                            </div>
                            <div class="collapsible-body white">
                                <div class="row">
                                    <div class="col s12 m8">
                                        <h6>Detalhes Atuais</h6>
                                        <p><i class="material-icons tiny left">location_on</i> {{ $oferta->rua }}, {{ $oferta->numero }} - {{ $oferta->bairro }}</p>
                                        <p><i class="material-icons tiny left">group</i> {{ ucfirst($oferta->tipo_vaga) }} ({{ $oferta->num_vagas }} vagas)</p>
                                        
                                        @if(isset($oferta->fotos) && count($oferta->fotos) > 0)
                                            <div style="margin-top:10px;">
                                                <img src="{{ Storage::url($oferta->fotos[0]) }}" style="height: 60px; width: 60px; object-fit: cover; border-radius: 4px; margin-right: 5px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col s12 m4 center-align">
                                        <h6>Ações</h6>
                                        
                                        <a href="{{ route('oferta.edit', $oferta->id) }}" class="btn waves-effect waves-light blue lighten-1" style="width: 100%; margin-bottom: 8px;">
                                            <i class="material-icons left">edit</i> Editar
                                        </a>

                                        <form action="{{ route('oferta.toggle', $oferta->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn waves-effect waves-light {{ $oferta->ativa ? 'amber darken-2' : 'green' }}" style="width: 100%; margin-bottom: 8px;">
                                                <i class="material-icons left">{{ $oferta->ativa ? 'pause' : 'play_arrow' }}</i>
                                                {{ $oferta->ativa ? 'Pausar' : 'Reativar' }}
                                            </button>
                                        </form>

                                        <a href="#modal-excluir-{{ $oferta->id }}" class="btn waves-effect waves-light red modal-trigger" style="width: 100%;">
                                            <i class="material-icons left">delete</i> Excluir
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div id="modal-excluir-{{ $oferta->id }}" class="modal">
                                <div class="modal-content left-align">
                                    <h4>Confirmar Exclusão</h4>
                                    <p>Tem certeza que deseja excluir a oferta <b>"{{ $oferta->titulo_anuncio }}"</b>?</p>
                                    <p class="red-text">Essa ação não pode ser desfeita.</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                                    
                                    <form action="{{ route('oferta.destroy', $oferta->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="waves-effect waves-light btn red">Confirmar Exclusão</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li>
                            <div class="collapsible-header"><i class="material-icons">info</i> Nenhuma oferta cadastrada.</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.Sidenav.init(document.querySelectorAll('.sidenav'));
            M.Collapsible.init(document.querySelectorAll('.collapsible'));
            M.Modal.init(document.querySelectorAll('.modal'));
        });
    </script>
</body>
</html>