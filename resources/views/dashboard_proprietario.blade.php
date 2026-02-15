<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Proprietário - SAMCA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @include('layouts.navigation_proprietario')
    <main>
        <div class="container custom-container" style="margin-top: 40px;">
            <div class="row">
                <div class="col s12 m8">
                    <h3>Painel de Gestão</h3>
                    <p class="grey-text">Bem-vindo, {{ explode(' ', $user->name)[0] }}. Gerencie seus imóveis e inquilinos aqui.</p>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4">
                    <div class="card-panel z-depth-1 center-align">
                        <i class="material-icons medium samca-color-text">home</i>
                        <h5>{{ $totalImoveis }}</h5>
                        <p>Imóveis Cadastrados</p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card-panel z-depth-1 center-align">
                        <i class="material-icons medium green-text">check_circle</i>
                        <h5>{{ $imoveisAtivos }}</h5>
                        <p>Anúncios Ativos</p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card-panel z-depth-1 center-align">
                        <i class="material-icons medium orange-text">chat</i>
                        <h5>{{ $mensagensNaoLidas }}</h5>
                        <p>Novas Mensagens</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 l5">
                    
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <span class="card-title">Mensagens Recentes</span>
                            @if($ultimasMensagens->count() > 0)
                                <ul class="collection">
                                    @foreach($ultimasMensagens as $msg)
                                        @php
                                            $otherUser = ($msg->from_id == $user->id) ? $msg->receiver : $msg->sender;
                                            $nome = $otherUser ? explode(' ', $otherUser->name)[0] : 'Usuário';
                                            $unread = ($msg->to_id == $user->id && !$msg->read);
                                        @endphp
                                        <a href="{{ route('messages.index') }}" class="collection-item avatar black-text {{ $unread ? 'blue lighten-5' : '' }}">
                                            <i class="material-icons circle samca-btn">person</i>
                                            <span class="title"><b>{{ $nome }}</b></span>
                                            <p class="truncate grey-text">{{ $msg->body }}</p>
                                        </a>
                                    @endforeach
                                </ul>
                            @else
                                <p class="grey-text center-align">Nenhuma mensagem recente.</p>
                            @endif
                            <div class="card-action">
                                <a href="{{ route('messages.index') }}" class="samca-link">Ver Caixa de Entrada</a>
                            </div>
                        </div>
                    </div>

                    @if($alunosInteressados->count() > 0)
                    <div class="card z-depth-1">
                        <div class="card-content">
                            <span class="card-title" style="font-size: 1.2rem;">Alunos procurando o que você tem:</span>
                            <ul class="collection">
                                @foreach($alunosInteressados as $aluno)
                                    <li class="collection-item">
                                        <div>
                                            {{ $aluno->name }}
                                            <div class="secondary-content">
                                                @if($aluno->pets) <i class="material-icons tiny tooltipped" data-tooltip="Tem Pet">pets</i> @endif
                                                @if($aluno->silencio) <i class="material-icons tiny tooltipped" data-tooltip="Gosta de Silêncio">volume_off</i> @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                </div>

                <div class="col s12 l7">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <span class="card-title">Meus Anúncios Recentes</span>
                            
                            @if($meusAnuncios->count() > 0)
                                <table class="highlight responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Preço</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($meusAnuncios as $anuncio)
                                        <tr>
                                            <td>{{ $anuncio->titulo_anuncio }}</td>
                                            <td>R$ {{ number_format($anuncio->preco_mensal, 2, ',', '.') }}</td>
                                            <td>
                                                @if($anuncio->ativa)
                                                    <span class="new badge green" data-badge-caption="Ativo"></span>
                                                @else
                                                    <span class="new badge grey" data-badge-caption="Inativo"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#!" class="btn-small blue lighten-2"><i class="material-icons">edit</i></a>
                                                <a href="#!" class="btn-small red lighten-2"><i class="material-icons">delete</i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="center-align" style="padding: 40px;">
                                    <i class="material-icons grey-text medium">home_work</i>
                                    <p>Você ainda não cadastrou nenhum imóvel.</p>
                                    <a href="#!" class="btn samca-btn">Cadastrar Primeiro Imóvel</a>
                                </div>
                            @endif
                        </div>
                        @if($meusAnuncios->count() > 0)
                        <div class="card-action right-align">
                            <a href="#!" class="samca-link">Ver Todos os Imóveis</a>
                        </div>
                        @endif
                    </div>
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
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        });
    </script>
</body>
</html>