<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @include('layouts.navigation_aluno')

    <main>
        <div class="container" style="margin-top: 30px; margin-bottom: 50px;">
            
            <div class="row">
                <div class="col s12">
                    <h3>Olá, {{ explode(' ', $user->name)[0] }}!</h3>
                    
                    @if($perfilIncompleto)
                    <div class="card-panel red lighten-4 z-depth-1">
                        <div class="row valign-wrapper" style="margin-bottom: 0;">
                            <div class="col s12">
                                <span class="red-text text-darken-4">
                                    <i class="material-icons left">warning</i> 
                                    <b>Atenção:</b> Seu perfil está incompleto. Complete para receber indicações melhores.
                                </span>
                                <a href="{{ route('aluno.perfil.editar') }}" class="btn-flat waves-effect red-text text-darken-4 right">
                                    Completar <i class="material-icons right">arrow_forward</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col s12 l4">
                    
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <span class="card-title" style="font-size: 1.2rem;">
                                <i class="material-icons left samca-color-text">chat</i> Mensagens
                            </span>
                            
                            @if(isset($ultimasMensagens) && $ultimasMensagens->count() > 0)
                                <ul class="collection" style="border: none; margin: 0;">
                                    @foreach($ultimasMensagens as $msg)
                                        @php
                                            // Tenta pegar o nome do outro usuário com segurança
                                            $otherName = 'Usuário';
                                            if($msg->from_id == $user->id && $msg->receiver) {
                                                $otherName = explode(' ', $msg->receiver->name)[0];
                                            } elseif($msg->sender) {
                                                $otherName = explode(' ', $msg->sender->name)[0];
                                            }
                                            
                                            $isUnread = ($msg->to_id == $user->id && !$msg->read);
                                        @endphp
                                        <li class="collection-item avatar" style="padding-left: 60px; {{ $isUnread ? 'background-color: #e3f2fd;' : '' }}">
                                            <i class="material-icons circle {{ $isUnread ? 'blue' : 'grey' }}">person</i>
                                            <span class="title"><b>{{ $otherName }}</b></span>
                                            <p class="truncate grey-text">{{ $msg->body }}</p>
                                            <a href="{{ route('aluno.mensagens') }}" class="secondary-content"><i class="material-icons tiny">send</i></a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="center-align" style="margin-top: 15px;">
                                    <a href="{{ route('aluno.mensagens') }}" class="samca-link">Ver todas</a>
                                </div>
                            @else
                                <p class="grey-text center-align" style="padding: 15px;">Nenhuma conversa iniciada.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card samca-info-card z-depth-1">
                        <div class="card-content">
                            <span class="card-title" style="font-size: 1.1rem;">Links Úteis UFERSA</span>
                            <div class="collection">
                                <a href="https://angicos.ufersa.edu.br/assistencia-estudantil/" target="_blank" class="collection-item black-text">
                                    <i class="material-icons left tiny">link</i> Assistência Estudantil
                                </a>
                                <a href="https://angicos.ufersa.edu.br/editais/" target="_blank" class="collection-item black-text">
                                    <i class="material-icons left tiny">description</i> Editais PNAES
                                </a>
                                <a href="https://sigaa.ufersa.edu.br/" target="_blank" class="collection-item black-text">
                                    <i class="material-icons left tiny">school</i> SIGAA
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col s12 l8">
                    
                    @if($melhorMatch)
                    <h5 class="grey-text text-darken-2" style="font-size: 1.2rem; margin-top: 0;">Sua Melhor Compatibilidade</h5>
                    <div class="card horizontal top-match-card hoverable z-depth-2">
                        <div class="card-image hide-on-small-only" style="width: 35%;">
                            @if(isset($melhorMatch->fotos) && count($melhorMatch->fotos) > 0)
                                <img src="{{ Storage::url($melhorMatch->fotos[0]) }}" style="height: 100%; object-fit: cover;">
                            @else
                                <img src="https://source.unsplash.com/random/400x300/?house" style="height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <span class="new badge amber darken-2" data-badge-caption="Top Match"></span>
                                <span class="card-title truncate">{{ $melhorMatch->titulo_anuncio }}</span>
                                
                                <p>
                                    <strong class="green-text">R$ {{ number_format($melhorMatch->preco_mensal, 2, ',', '.') }}</strong> 
                                    <span class="grey-text text-lighten-1">|</span> {{ ucfirst($melhorMatch->tipo_vaga) }}
                                </p>
                                <p class="grey-text truncate"><i class="material-icons tiny">place</i> {{ $melhorMatch->bairro }}</p>

                                <div class="match-score-bar">
                                    <div class="match-fill orange darken-1" style="width: {{ $melhorMatch->match_score }}%"></div>
                                </div>
                                <small class="orange-text text-darken-2"><b>{{ $melhorMatch->match_score }}% Compatível</b> (Baseado nos seus hábitos)</small>
                            </div>
                            <div class="card-action right-align">
                                <a href="#modal-oferta" class="btn samca-btn modal-trigger ver-detalhes"
                                data-titulo="{{ $melhorMatch->titulo_anuncio }}"
                                data-preco="{{ number_format($melhorMatch->preco_mensal, 2, ',', '.') }}"
                                data-tipo="{{ ucfirst($melhorMatch->tipo_vaga) }}"
                                data-vagas="{{ $melhorMatch->num_vagas }}"
                                data-endereco="{{ $melhorMatch->rua ?? '' }}, {{ $melhorMatch->numero ?? '' }} - {{ $melhorMatch->bairro ?? '' }}"
                                data-descricao="{{ $melhorMatch->resumo_regras ?? 'Sem descrição detalhada.' }}"
                                data-img="{{ isset($melhorMatch->fotos) && count($melhorMatch->fotos) > 0 ? Storage::url($melhorMatch->fotos[0]) : 'https://source.unsplash.com/random/800x600/?house' }}"
                                data-owner="{{ $melhorMatch->user_id }}">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card-panel grey lighten-4 center-align">
                        <i class="material-icons large grey-text text-lighten-2">home</i>
                        <p>Complete seu perfil para ver sua melhor compatibilidade aqui!</p>
                    </div>
                    @endif

                    @if(isset($outrasSugestoes) && count($outrasSugestoes) > 0)
                    <h5 class="grey-text text-darken-2" style="font-size: 1.2rem; margin-top: 30px;">Outras Opções para Você</h5>
                    <div class="row">
                        @foreach($outrasSugestoes as $sugestao)
                        <div class="col s12 m6">
                            <div class="card hoverable sticky-action">
                                <div class="card-image waves-effect waves-block waves-light">
                                    @if(isset($sugestao->fotos) && count($sugestao->fotos) > 0)
                                        <img class="activator" src="{{ Storage::url($sugestao->fotos[0]) }}">
                                    @else
                                        <img class="activator" src="https://source.unsplash.com/random/400x300/?bedroom">
                                    @endif
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4 truncate" style="font-size: 1.1rem;">
                                        {{ $sugestao->titulo_anuncio }}
                                        <i class="material-icons right">more_vert</i>
                                    </span>
                                    <p class="green-text text-darken-2"><b>R$ {{ number_format($sugestao->preco_mensal, 2, ',', '.') }}</b></p>
                                    
                                    <div class="match-score-bar">
                                        <div class="match-fill" style="width: {{ $sugestao->match_score }}%"></div>
                                    </div>
                                    <small class="grey-text">{{ $sugestao->match_score }}% Match</small>
                                </div>
                                <div class="card-action">
                                    <a href="#modal-oferta" class="samca-link modal-trigger ver-detalhes"
                                    data-titulo="{{ $sugestao->titulo_anuncio }}"
                                    data-preco="{{ number_format($sugestao->preco_mensal, 2, ',', '.') }}"
                                    data-tipo="{{ ucfirst($sugestao->tipo_vaga) }}"
                                    data-vagas="{{ $sugestao->num_vagas }}"
                                    data-endereco="{{ $sugestao->bairro }}"
                                    data-descricao="{{ $sugestao->resumo_regras ?? 'Sem descrição.' }}"
                                    data-img="{{ isset($sugestao->fotos) && count($sugestao->fotos) > 0 ? Storage::url($sugestao->fotos[0]) : 'https://source.unsplash.com/random/400x300/?room' }}"
                                    data-owner="{{ $sugestao->user_id }}">
                                        Ver Vaga
                                    </a>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">{{ $sugestao->bairro }}<i class="material-icons right">close</i></span>
                                    <p>{{ Str::limit($sugestao->resumo_regras, 100) }}</p>
                                    <p>Clique em "Ver Vaga" para contatar o proprietário.</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <div id="modal-oferta" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 id="modal-titulo" class="samca-color-text" style="font-size: 1.5rem; margin-bottom: 20px;">Título do Anúncio</h4>
            
            <div class="row">
                <div class="col s12 m6">
                    <img id="modal-img" src="" class="responsive-img z-depth-1" style="border-radius: 8px; width: 100%; height: 250px; object-fit: cover;">
                </div>
                
                <div class="col s12 m6">
                    <p style="font-size: 1.3rem; margin-top: 0;">R$ <span id="modal-preco" class="green-text text-darken-2">0,00</span> <small class="grey-text">/mês</small></p>
                    
                    <ul class="collection">
                        <li class="collection-item">
                            <i class="material-icons tiny left">hotel</i> Tipo: <span id="modal-tipo" style="font-weight: bold;">-</span>
                        </li>
                        <li class="collection-item">
                            <i class="material-icons tiny left">group</i> Vagas: <span id="modal-vagas" style="font-weight: bold;">-</span>
                        </li>
                        <li class="collection-item">
                            <i class="material-icons tiny left">place</i> <span id="modal-endereco">-</span>
                        </li>
                    </ul>

                    <p><strong>Regras/Descrição:</strong></p>
                    <p id="modal-descricao" class="grey-text text-darken-2" style="font-size: 0.9rem;">...</p>
                </div>
            </div>

            <div class="row" style="background-color: #f5f5f5; padding: 15px; border-radius: 8px; margin-top: 10px;">
                <div class="col s12">
                    <span class="card-title" style="font-size: 1rem;"><i class="material-icons left tiny">message</i> Enviar mensagem ao proprietário:</span>
                    <form id="form-mensagem-modal" action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="to_id" id="modal-owner-id">
                        
                        <div class="input-field">
                            <textarea id="mensagem-texto" name="body" class="materialize-textarea" required placeholder="Olá, tenho interesse na vaga..."></textarea>
                        </div>
                        <button type="submit" class="btn waves-effect waves-light samca-btn right">
                            Enviar <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-grey btn-flat">Fechar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalElems = document.querySelectorAll('.modal');
            M.Modal.init(modalElems);

            M.Sidenav.init(document.querySelectorAll('.sidenav'));

            document.querySelectorAll('.ver-detalhes').forEach(button => {
                button.addEventListener('click', function(e) {
                    
                    let titulo = this.dataset.titulo;
                    let preco = this.dataset.preco;
                    let tipo = this.dataset.tipo;
                    let vagas = this.dataset.vagas;
                    let endereco = this.dataset.endereco;
                    let descricao = this.dataset.descricao;
                    let img = this.dataset.img;
                    let ownerId = this.dataset.owner;

                    document.getElementById('modal-titulo').innerText = titulo;
                    document.getElementById('modal-preco').innerText = preco;
                    document.getElementById('modal-tipo').innerText = tipo;
                    document.getElementById('modal-vagas').innerText = vagas;
                    document.getElementById('modal-endereco').innerText = endereco;
                    document.getElementById('modal-descricao').innerText = descricao;
                    document.getElementById('modal-img').src = img;
                    document.getElementById('modal-owner-id').value = ownerId;
                });
            });
            let formMensagem = document.getElementById('form-mensagem-modal');
            if(formMensagem) {
                formMensagem.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('mensagem-texto').value = '';

                        var modalInstance = M.Modal.getInstance(document.getElementById('modal-oferta'));
                        modalInstance.close();
                        
                        M.toast({html: 'Mensagem enviada com sucesso!', classes: 'green darken-1'});
                    })
                    .catch(error => {
                        console.error(error);
                        M.toast({html: 'Erro ao enviar mensagem. Tente novamente.', classes: 'red darken-1'});
                    });
                });
            }
        });
    </script>
</body>
</html>