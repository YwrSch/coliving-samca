<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Encontre sua Moradia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
         integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
         crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
         integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
         crossorigin=""></script>
    </head>
<body>
    <main>
        <nav class="samca-nav">
            <div class="nav-wrapper container">
                <a href="/" class="brand-logo samca-title">Coliving SAMCA</a>
                <a href="#" data-target="nav-mobile-index" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{ route('login') }}"><i class="material-icons left">input</i>Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="material-icons left">person_add</i>Cadastrar-se</a></li>
                </ul>
            </div>
        </nav>
        <ul class="sidenav" id="nav-mobile-index">
            <li><a href="{{ route('login') }}"><i class="material-icons left">input</i>Login</a></li>
            <li><a href="{{ route('register') }}"><i class="material-icons left">person_add</i>Cadastrar-se</a></li>
        </ul>

        <div class="container">
            <div class="row section">
                <div class="col s12 m4">
                    <div class="card-panel z-depth-2">
                        <h5 class="center-align samca-color-text">Refinar Busca</h5>
                        
                        <form id="form-filtros" action="/" method="GET">
                            
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
                                <a href="/" class="btn-flat samca-link">Limpar Filtros</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col s12 m8">
                    <h5 class="grey-text text-darken-2">Moradias Encontradas em Angicos</h5>
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
                                <a href="#modal-login" class="samca-link modal-trigger">Ver Detalhes</a>
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
                        <div class="center-align grey-text text-darken-1" style="padding: 5px;">
                            <i class="material-icons tiny">place</i> Mapa Iterativo (OpenStreetMap).
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        
        <div id="modal-login" class="modal">
            <div class="modal-content center-align">
                <i class="material-icons large samca-color-text" style="font-size: 60px;">lock_outline</i>
                <h4>Conteúdo Exclusivo!</h4>
                <p>Para visualizar todos os detalhes, você precisa estar logado(a).</p>
            </div>
            <div class="modal-footer center-align">
                <a href="{{ route('login') }}" class="waves-effect waves-light btn samca-btn">Fazer Login</a>
                <a href="{{ route('register') }}" class="modal-close waves-effect waves-green btn-flat samca-link">Novo por aqui? Registre-se!</a>
            </div>
        </div>

    </main>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script>
        const UFERSA_ANGICOS = [-5.654591768564729, -36.61251325403497];
        const ANGICOS = [-5.66276110305684, -36.60093044175749];
        
        const moradias = {!! $mapMarkers !!};

        function limparFiltros() {
            var form = document.getElementById('form-filtros');
            form.reset();
            var selectElements = document.querySelectorAll('select');
            M.FormSelect.init(selectElements);       
            M.toast({html: 'Filtros limpos. Exibindo todas as moradias.', classes: 'grey darken-1'});
        };

        document.addEventListener('DOMContentLoaded', function() {
            M.FormSelect.init(document.querySelectorAll('select'));
            M.Sidenav.init(document.querySelectorAll('.sidenav'));
            M.Modal.init(document.querySelectorAll('.modal'));
            
            document.querySelectorAll('.moradia-oferta').forEach(function(offer) {});

            try {
                var map = L.map('mapa-interativo').setView(ANGICOS, 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                L.marker(UFERSA_ANGICOS).addTo(map)
                    .bindPopup('<b>UFERSA Campus Angicos</b>');

                moradias.forEach(moradia => {
                    var popupContent = `<b>${moradia.titulo}</b><br>R$ ${moradia.preco}`;
                    
                    if (moradia.foto) {
                        var fotoUrl = '/storage/' + moradia.foto;
                        popupContent += `<br><img src="${fotoUrl}" alt="${moradia.titulo}" style="width:100px; margin-top:5px;">`;
                    }

                    L.marker(moradia.latlng).addTo(map)
                        .bindPopup(popupContent);
                });
            } catch (e) {
                console.error("Erro ao inicializar o mapa Leaflet: ", e);
            }
        });
    </script>
</body>
</html>