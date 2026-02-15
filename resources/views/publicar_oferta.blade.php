<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Publicar Nova Oferta</title>
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
    
    @include('layouts.navigation_proprietario')

    <main>
        <div class="container custom-container">
            <div class="row">
                <div class="col s12">
                    <h4>Publicar Nova Oferta de Moradia</h4>
                    <p class="flow-text grey-text text-darken-1">Preencha os dados abaixo para anunciar sua vaga ou imóvel para estudantes da UFERSA.</p>
                    <div class="divider"></div>
                </div>
                
                <form method="POST" action="{{ route('proprietario.oferta.store') }}" id="form-publicar-oferta" enctype="multipart/form-data">
                    @csrf

                    <div class="col s12 form-step">
                        <div class="card-panel z-depth-2">
                            <h5 class="samca-color-text"><i class="material-icons left">location_on</i> 1. Localização e Tipo de Imóvel</h5>
                            
                            <div class="input-field">
                                <i class="material-icons prefix">title</i>
                                <input id="titulo-anuncio" name="titulo_anuncio" type="text" value="{{ old('titulo_anuncio') }}" required>
                                <label for="titulo-anuncio">Título do Anúncio (Ex: República Sol Nascente)</label>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <select id="tipo-imovel" name="tipo_imovel" required>
                                    <option value="" disabled selected>Escolha o Tipo</option>
                                    <option value="casa">Casa</option>
                                    <option value="apartamento">Apartamento</option>
                                    <option value="republica">Vaga em República (Pensionato)</option>
                                </select>
                                <label>Tipo de Imóvel</label>
                            </div>

                            <div class="row" style="margin-bottom: 0;">
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">subtitles</i>
                                    <input id="bairro" name="bairro" type="text" value="{{ old('bairro') }}" required>
                                    <label for="bairro">Bairro</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">place</i>
                                    <input id="rua" name="rua" type="text" value="{{ old('rua') }}" required>
                                    <label for="rua">Rua / Avenida</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">looks_one</i>
                                    <input id="numero" name="numero" type="text" value="{{ old('numero') }}" required>
                                    <label for="numero">Número</label>
                                    <span class="helper-text">Será usado para calcular a distância do Campus UFERSA.</span>
                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">room_service</i>
                                    <input id="complemento" name="complemento" value="{{ old('complemento') }}" type="text">
                                    <label for="complemento">Complemento (Opcional)</label>
                                </div>
                            </div>

                            <h6 class="samca-color-text" style="margin-top: 20px;">1.B. Selecione a Localização Exata no Mapa</h6>
                            <p>Clique no local exato da moradia para definir as coordenadas.</p>
                            <div id="mapa-selecao" style="height: 300px; width: 100%; border: 2px dashed var(--samca-primary-color); border-radius: 5px; cursor: pointer;"></div>
                            
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <div class="file-field input-field" style="margin-top: 20px;">
                                <div class="btn samca-btn">
                                    <span><i class="material-icons">photo_camera</i> Fotos</span>
                                    <input type="file" name="fotos[]" multiple accept="image/*" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Carregue pelo menos 3 fotos do imóvel">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 form-step">
                        <div class="card-panel z-depth-2">
                            <h5 class="samca-color-text"><i class="material-icons left">attach_money</i> 2. Vagas, Preços e Custos</h5>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">group</i>
                                    <select id="tipo-vaga" name="tipo_vaga" required>
                                        <option value="" disabled selected>Tipo de Acomodação</option>
                                        <option value="individual">Quarto Individual</option>
                                        <option value="compartilhado">Quarto Compartilhado</option>
                                        <option value="imovel_inteiro">Imóvel Inteiro (aluguel para um grupo)</option>
                                    </select>
                                    <label>Tipo de Vaga Ofertada</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">label_outline</i>
                                    <input id="num-vagas" name="num_vagas" type="number" value="{{ old('num_vagas') }}" min="1" required>
                                    <label for="num-vagas">Número de Vagas Disponíveis</label>
                                </div>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">money</i>
                                <input id="preco-mensal" name="preco_mensal" type="number" value="{{ old('preco_mensal') }}" min="50" required>
                                <label for="preco-mensal">Preço Mensal (por pessoa)</label>
                            </div>
                            <h6>Custos Inclusos no Valor Mensal:</h6>
                            <div class="row">
                                <div class="col s12 m4">
                                    <label><input type="checkbox" name="custos[]" value="agua" /><span>Água</span></label>
                                </div>
                                <div class="col s12 m4">
                                    <label><input type="checkbox" name="custos[]" value="luz" /><span>Energia (Luz)</span></label>
                                </div>
                                <div class="col s12 m4">
                                    <label><input type="checkbox" name="custos[]" value="internet" /><span>Internet (Wi-Fi)</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 form-step">
                        <div class="card-panel z-depth-2">
                            <h5 class="samca-color-text"><i class="material-icons left">settings</i> 3. Comodidades e Regras</h5>
                            <h6>Comodidades do Imóvel:</h6>
                            <div class="row">
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="comodidades[]" value="garagem" /><span>Garagem/Vaga</span></label>
                                </div>
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="comodidades[]" value="servico" /><span>Área de Serviço/Lavanderia</span></label>
                                </div>
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="comodidades[]" value="mobiliado" /><span>Mobiliado (Quartos e Áreas Comuns)</span></label>
                                </div>
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="comodidades[]" value="cozinha" /><span>Cozinha Completa</span></label>
                                </div>
                            </div>
                            <div class="divider" style="margin: 20px 0;"></div>
                            <h6>Regras de Convivência:</h6>
                            <div class="row">
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="regras[]" value="pet" /><span>Aceita Pets</span></label>
                                </div>
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="regras[]" value="fumo" /><span>Permite Fumar no Local</span></label>
                                </div>
                                <div class="col s12 m6">
                                    <label><input type="checkbox" name="regras[]" value="silencio" /><span>Exige Silêncio Absoluto após 22h</span></label>
                                </div>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">edit</i>
                                <textarea id="resumo-regras" name="resumo_regras" class="materialize-textarea" data-length="500">{{ old('resumo_regras') }}</textarea>
                                <label for="resumo-regras">Resumo e Regras Adicionais (Opcional)</label>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 center-align">
                        <button class="btn large waves-effect waves-light samca-btn" type="submit" name="action">
                            Publicar Oferta no SAMCA
                            <i class="material-icons right">send</i>
                        </button>
                        <p style="margin-top: 15px;">A oferta será salva e enviada para análise.</p>
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
            M.FormSelect.init(document.querySelectorAll('select'));
            M.updateTextFields();
            M.CharacterCounter.init(document.querySelectorAll('textarea'));
            M.Sidenav.init(document.querySelectorAll('.sidenav'));

            const ANGICOS = [-5.66276110305684, -36.60093044175749];
            var map = L.map('mapa-selecao').setView(ANGICOS, 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            var marcador = null; 
            var latInput = document.getElementById('latitude');
            var lngInput = document.getElementById('longitude');

            map.on('click', function(e) {
                var coords = e.latlng;
                latInput.value = coords.lat.toFixed(6); 
                lngInput.value = coords.lng.toFixed(6);

                if (marcador) {
                    marcador.setLatLng(coords);
                } else {
                    marcador = L.marker(coords, { draggable: true }).addTo(map)
                               .bindPopup('Localização da sua moradia. (Arraste para ajustar)').openPopup();
                }
                
                marcador.on('dragend', function(e) {
                    var newCoords = e.target.getLatLng();
                    latInput.value = newCoords.lat.toFixed(6);
                    lngInput.value = newCoords.lng.toFixed(6);
                    M.toast({html: 'Localização reajustada!', classes: 'green'});
                });

                M.toast({html: 'Localização definida! (Você pode arrastar o pino)', classes: 'green'});
            });

            document.getElementById('form-publicar-oferta').addEventListener('submit', function(e) {
                if (!latInput.value || !lngInput.value) {
                    e.preventDefault(); 
                    M.toast({html: 'Erro: Por favor, clique no mapa para definir a localização!', classes: 'red darken-1'});
                } else {
                    this.querySelector('button[type="submit"]').disabled = true;
                    M.toast({html: 'Enviando oferta...', classes: 'blue'});
                }
            });
        });
    </script>
</body>
</html>