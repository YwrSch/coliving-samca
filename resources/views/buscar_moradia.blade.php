<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Coliving SAMCA - Buscar Moradia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    
    @include('layouts.navigation_aluno')

    <main>
        <div class="container">
            <div class="row section">
                <div class="col s12 m4">
                    <div class="card-panel z-depth-2">
                        <h5 class="center-align samca-color-text">Refinar Busca</h5>
                        <form id="form-filtros" action="{{ route('aluno.buscar') }}" method="GET">
                            
                            <div class="input-field">
                                <i class="material-icons prefix">attach_money</i>
                                <select id="filtro-preco" name="preco">
                                    <option value="" disabled {{ request('preco') ? '' : 'selected' }}>Qual seu orçamento máximo?</option>
                                    <option value="1" {{ request('preco') == '1' ? 'selected' : '' }}>Até R$ 300</option>
                                    <option value="2" {{ request('preco') == '2' ? 'selected' : '' }}>R$ 301 - R$ 500</option>
                                    <option value="3" {{ request('preco') == '3' ? 'selected' : '' }}>R$ 501 - R$ 700</option>
                                    <option value="4" {{ request('preco') == '4' ? 'selected' : '' }}>Acima de R$ 700</option>
                                </select>
                                <label>Faixa de Preço (por pessoa)</label>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix">directions_walk</i>
                                <select id="filtro-distancia" name="distancia">
                                    <option value="" disabled {{ request('distancia') ? '' : 'selected' }}>Distância Máxima do Campus</option>
                                    <option value="1" {{ request('distancia') == '1' ? 'selected' : '' }}>Até 1 km</option>
                                    <option value="2" {{ request('distancia') == '2' ? 'selected' : '' }}>Até 3 km</option>
                                    <option value="3" {{ request('distancia') == '3' ? 'selected' : '' }}>Até 5 km</option>
                                    <option value="4" {{ request('distancia') == '4' ? 'selected' : '' }}>Qualquer distância</option>
                                </select>
                                <label>Distância da Instituição</label>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <select id="filtro-acomodacao" name="acomodacao">
                                    <option value="" disabled {{ request('acomodacao') ? '' : 'selected' }}>Tipo de Acomodação</option>
                                    <option value="1" {{ request('acomodacao') == '1' ? 'selected' : '' }}>Quarto Individual</option>
                                    <option value="2" {{ request('acomodacao') == '2' ? 'selected' : '' }}>Quarto Compartilhado</option>
                                    <option value="3" {{ request('acomodacao') == '3' ? 'selected' : '' }}>Vaga em República</option>
                                    <option value="4" {{ request('acomodacao') == '4' ? 'selected' : '' }}>Imóvel Inteiro (Para grupo)</option>
                                </select>
                                <label>Acomodação</label>
                            </div>
                            
                            <div class="divider" style="margin: 20px 0;"></div>

                            <h6>Comodidades e Preferências:</h6>
                            <div class="row">
                                <div class="col s12">
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="garagem" value="1" {{ request('garagem') ? 'checked' : '' }} />
                                        <span>Garagem / Vaga</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="servico" value="1" {{ request('servico') ? 'checked' : '' }} />
                                        <span>Área de Serviço / Lavanderia</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="mobiliado" value="1" {{ request('mobiliado') ? 'checked' : '' }} />
                                        <span>Mobiliado (Quartos e Áreas Comuns)</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="cozinha" value="1" {{ request('cozinha') ? 'checked' : '' }} />
                                        <span>Cozinha Completa</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="pets" value="1" {{ request('pets') ? 'checked' : '' }} />
                                        <span>Aceita Pets</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="fumar" value="1" {{ request('fumar') ? 'checked' : '' }} />
                                        <span>Permite Fumar</span>
                                    </label>
                                    <label style="margin-bottom: 10px; display: block;">
                                        <input type="checkbox" class="filled-in" name="silencio" value="1" {{ request('silencio') ? 'checked' : '' }} />
                                        <span>Exige Silêncio Absoluto</span>
                                    </label>
                                </div>
                            </div>

                            <div class="center-align" style="margin-top: 30px;">
                                <button class="btn waves-effect waves-light samca-btn" type="submit">
                                    Aplicar Filtros
                                </button>
                                <a href="{{ route('aluno.buscar') }}" class="btn-flat samca-link">Limpar Filtros</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col s12 m8">
                    <h5 class="grey-text text-darken-2">Resultados da Busca</h5>
                    
                    @forelse($ofertas as $oferta)
                    <div class="card horizontal hoverable moradia-oferta">
                        <div class="card-image hide-on-small-only">
                            @if(isset($oferta->fotos) && count($oferta->fotos) > 0)
                                <img src="{{ Storage::url($oferta->fotos[0]) }}" style="width: 150px; height: 100%; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/150x150?text=Sem+Foto" style="width: 150px; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <span class="card-title">{{ $oferta->titulo_anuncio }}</span>
                                <p>
                                    <b>R$ {{ number_format($oferta->preco_mensal, 2, ',', '.') }}</b> | {{ $oferta->bairro }}<br>
                                    {{ $oferta->num_vagas }} Vagas ({{ ucfirst($oferta->tipo_vaga) }})
                                </p>
                            </div>
                            <div class="card-action">
                                <a href="#modal-detalhes-moradia" 
                                class="samca-link modal-trigger btn-detalhes"
                                data-titulo="{{ $oferta->titulo_anuncio }}"
                                data-preco="R$ {{ number_format($oferta->preco_mensal, 2, ',', '.') }}/mês"
                                data-bairro="{{ $oferta->bairro }}"
                                data-descricao="{{ $oferta->resumo_regras ?? 'Sem descrição adicional.' }}"
                                data-comodidades="{{ json_encode($oferta->comodidades ?? []) }}"
                                data-fotos="{{ json_encode($oferta->fotos ?? []) }}"
                                data-tipo="{{ ucfirst($oferta->tipo_vaga) }}"
                                data-prop-id="{{ $oferta->user_id }}"
                                data-prop-nome="{{ $oferta->proprietario->name }} {{ $oferta->proprietario->sobrenome }}"
                                data-prop-email="{{ $oferta->proprietario->email }}"
                                data-prop-telefone="{{ $oferta->proprietario->telefone }}"
                                >Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card-panel">
                        <p class="center-align">Nenhuma moradia encontrada com estes filtros.</p>
                    </div>
                    @endforelse

                    <div class="card-panel z-depth-1" style="padding: 0; margin-top: 30px;">
                        <div id="mapa-interativo" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <div id="modal-detalhes-moradia" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="carousel carousel-slider center" id="modal-carousel">
                <div class="carousel-fixed-item center">
                    <h5 class="white-text" style="text-shadow: 2px 2px 4px #000;">Carregando imagens...</h5>
                </div>
            </div>
            
            <h4 id="detalhes-titulo" style="margin-top: 20px;">Título da Oferta</h4>
            <div class="row">
                <div class="col s12 m6">
                    <h6><i class="material-icons left samca-color-text">attach_money</i> Valor</h6>
                    <p class="flow-text samca-color-text" id="detalhes-valor">R$ 0,00</p>
                    
                    <h6><i class="material-icons left samca-color-text">location_on</i> Localização</h6>
                    <p id="detalhes-bairro">Bairro</p>
                    
                    <h6><i class="material-icons left samca-color-text">group</i> Tipo</h6>
                    <p id="detalhes-tipo">Tipo de Vaga</p>
                </div>

                <div class="col s12 m6">
                    <h6><i class="material-icons left samca-color-text">description</i> Descrição / Regras</h6>
                    <p id="detalhes-descricao">Descrição...</p>
                    
                    <h6><i class="material-icons left samca-color-text">check_circle</i> Comodidades</h6>
                    <div id="detalhes-comodidades">
                        </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Fechar</a>
            <button id="btn-abrir-contato" class="waves-effect waves-light btn samca-btn">
                <i class="material-icons left">message</i> Contatar
            </button>
        </div>
    </div>

    <div id="modal-contato" class="modal">
        <div class="modal-content">
            <h4 class="samca-color-text"><i class="material-icons left">contact_mail</i> Contatar Proprietário</h4>
            <div class="divider"></div>
            <br>
            
            <div class="row">
                <div class="col s12 m6">
                    <p><b>Nome:</b> <span id="contato-nome">Carregando...</span></p>
                </div>
                <div class="col s12 m6">
                    <p><b>E-mail:</b> <span id="contato-email">Carregando...</span></p>
                </div>
                <div class="col s12">
                    <p><b>Telefone:</b> <span id="contato-telefone">Carregando...</span></p>
                </div>
            </div>

            <form id="form-mensagem-inicial">
                <div class="input-field">
                    <i class="material-icons prefix">chat</i>
                    <textarea id="mensagem-texto" class="materialize-textarea" maxlength="150" data-length="150"></textarea>
                    <label for="mensagem-texto">Sua mensagem inicial (Máx. 150 caracteres)</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancelar</a>
            <button id="btn-enviar-mensagem" class="waves-effect waves-light btn samca-btn">
                Enviar Mensagem <i class="material-icons right">send</i>
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        const moradias = {!! $mapMarkers !!};
        const ANGICOS_CENTER = [-5.66276110305684, -36.60093044175749]; 
        let propId = null;

        document.addEventListener('DOMContentLoaded', function() {
            M.FormSelect.init(document.querySelectorAll('select'));
            M.Sidenav.init(document.querySelectorAll('.sidenav'));
            M.CharacterCounter.init(document.querySelectorAll('textarea'));

            var modalDetalhes = M.Modal.init(document.getElementById('modal-detalhes-moradia'));
            var modalContato = M.Modal.init(document.getElementById('modal-contato'));

            var btnsDetalhes = document.querySelectorAll('.btn-detalhes');
            
            btnsDetalhes.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); 

                    var titulo = this.getAttribute('data-titulo');
                    var preco = this.getAttribute('data-preco');
                    var bairro = this.getAttribute('data-bairro');
                    var descricao = this.getAttribute('data-descricao');
                    var tipo = this.getAttribute('data-tipo');
                    var fotos = JSON.parse(this.getAttribute('data-fotos'));
                    var comodidades = JSON.parse(this.getAttribute('data-comodidades'));

                    propId = this.getAttribute('data-prop-id');
                    var propNome = this.getAttribute('data-prop-nome');
                    var propEmail = this.getAttribute('data-prop-email');
                    var propTelefone = this.getAttribute('data-prop-telefone');

                    document.getElementById('detalhes-titulo').innerText = titulo;
                    document.getElementById('detalhes-valor').innerText = preco;
                    document.getElementById('detalhes-bairro').innerText = bairro;
                    document.getElementById('detalhes-descricao').innerText = descricao;
                    document.getElementById('detalhes-tipo').innerText = tipo;

                    document.getElementById('contato-nome').innerText = propNome;
                    document.getElementById('contato-email').innerText = propEmail;
                    document.getElementById('contato-telefone').innerText = propTelefone;

                    document.getElementById('mensagem-texto').value = `Olá! Tenho interesse na sua oferta "${titulo}". Podemos conversar?`;
                    M.updateTextFields();
                    M.textareaAutoResize(document.getElementById('mensagem-texto'));

                    var divComodidades = document.getElementById('detalhes-comodidades');
                    divComodidades.innerHTML = '';
                    if(comodidades && comodidades.length > 0) {
                        comodidades.forEach(item => {
                            var texto = item.charAt(0).toUpperCase() + item.slice(1);
                            divComodidades.innerHTML += `<span class="chip">${texto}</span>`;
                        });
                    } else {
                        divComodidades.innerHTML = '<span>Nenhuma informada.</span>';
                    }

                    var carouselElement = document.getElementById('modal-carousel');
                    if (carouselElement.classList.contains('initialized')) {
                        carouselElement.classList.remove('initialized');
                    }
                    var htmlSlides = '';
                    if (fotos && fotos.length > 0) {
                        fotos.forEach(function(fotoPath) {
                            var urlCompleta = '/storage/' + fotoPath;
                            htmlSlides += `<a class="carousel-item" href="#!"><img src="${urlCompleta}"></a>`;
                        });
                    } else {
                        htmlSlides = `<a class="carousel-item" href="#!"><img src="https://via.placeholder.com/600x300?text=Sem+Fotos"></a>`;
                    }
                    carouselElement.innerHTML = htmlSlides;
                    M.Carousel.init(carouselElement, { fullWidth: true, indicators: true, duration: 200 });

                    modalDetalhes.open();
                });
            });

            document.getElementById('btn-abrir-contato').addEventListener('click', function() {
                modalDetalhes.close();
                setTimeout(function() {
                    modalContato.open();
                }, 300);
            });

            document.getElementById('btn-enviar-mensagem').addEventListener('click', function() {
                var msgField = document.getElementById('mensagem-texto');
                var msg = msgField.value;
                var btn = this;

                if(msg.trim() === '') {
                    M.toast({html: 'Por favor, escreva uma mensagem.', classes: 'red'});
                    return;
                }
                btn.disabled = true;
                btn.innerHTML = 'Enviando...';
                
                fetch("{{ route('messages.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        to_id: propId,
                        body: msg
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        M.toast({html: 'Mensagem enviada! Verifique sua caixa de entrada.', classes: 'green darken-1'});
                        var instance = M.Modal.getInstance(document.getElementById('modal-contato'));
                        instance.close();
                        msgField.value = '';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    M.toast({html: 'Erro ao enviar mensagem.', classes: 'red'});
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = 'Enviar Mensagem <i class="material-icons right">send</i>';
                });
            });
            try {
                var map = L.map('mapa-interativo').setView(ANGICOS_CENTER, 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
                
                moradias.forEach(moradia => {
                    var popup = `<b>${moradia.titulo}</b><br>R$ ${moradia.preco}`;
                    if(moradia.foto) {
                        popup += `<br><img src="/storage/${moradia.foto}" style="width:100px; margin-top:5px;">`;
                    }
                    L.marker(moradia.latlng).addTo(map).bindPopup(popup);
                });
            } catch(e) { console.error(e); }
        });
    </script>
</body>
</html>