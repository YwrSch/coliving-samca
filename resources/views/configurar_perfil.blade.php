<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Configurar Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @include('layouts.navigation_aluno')

    <main>

        <div class="container custom-container" style="margin-top: 40px;">
            
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        M.toast({html: '{{ session('success') }}', classes: 'green darken-1'});
                    });
                </script>
            @endif

            @if($errors->any())
                <div class="card-panel red lighten-4 red-text text-darken-4">
                    <b>Por favor, corrija os erros:</b>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col s12 m10 offset-m1 l8 offset-l2">
                    <div class="card-panel z-depth-3">
                        <h4 class="center-align samca-color-text">Complete seu Perfil</h4>
                        <h5 class="center-align grey-text text-darken-2" style="font-size: 1.2rem;">Para melhores recomendações de moradia</h5>
                        <div class="divider"></div>
                        <br>

                        <form action="{{ route('aluno.perfil.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <h6 class="col s12 samca-color-text">1. Dados Acadêmicos</h6>
                                
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">book</i>
                                    <select id="curso" name="curso" required>
                                        <option value="" disabled selected>Selecione o Curso</option>
                                        <option value="si" {{ $user->curso == 'si' ? 'selected' : '' }}>Sistemas de Informação</option>
                                        <option value="pedagogia" {{ $user->curso == 'pedagogia' ? 'selected' : '' }}>Pedagogia</option>
                                        <option value="ct" {{ $user->curso == 'ct' ? 'selected' : '' }}>Ciências e Tecnologias</option>
                                        <option value="lc" {{ $user->curso == 'lc' ? 'selected' : '' }}>Licenciatura em Computação</option>
                                        <option value="ec" {{ $user->curso == 'ec' ? 'selected' : '' }}>Engenharia Civil</option>
                                        <option value="ep" {{ $user->curso == 'ep' ? 'selected' : '' }}>Engenharia da Produção</option>
                                    </select>
                                    <label for="curso">Curso na UFERSA Angicos</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input id="ingresso" name="ingresso" type="text" class="datepicker-mes-ano" placeholder="Ex: Mar/2024" value="{{ old('ingresso', $user->ingresso) }}" required>
                                    <label for="ingresso">Período de Ingresso</label>
                                </div>
                                
                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">event_available</i>
                                    <input id="conclusao" name="conclusao" type="text" class="datepicker-mes-ano" placeholder="Ex: Dez/2028" value="{{ old('conclusao', $user->conclusao) }}" required>
                                    <label for="conclusao">Expectativa de Conclusão</label>
                                </div>
                            </div>
                            
                            <div class="row">
                                <h6 class="col s12 samca-color-text">2. Informações Pessoais</h6>

                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">wc</i>
                                    <select id="genero" name="genero" required>
                                        <option value="" disabled selected>Selecione o Gênero</option>
                                        <option value="f" {{ $user->genero == 'f' ? 'selected' : '' }}>Feminino</option>
                                        <option value="m" {{ $user->genero == 'm' ? 'selected' : '' }}>Masculino</option>
                                        <option value="o" {{ $user->genero == 'o' ? 'selected' : '' }}>Outro/Prefiro Não Informar</option>
                                    </select>
                                    <label for="genero">Gênero</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <i class="material-icons prefix">cake</i>
                                    <input id="nascimento" name="nascimento" type="text" class="datepicker-data" placeholder="dd/mm/aaaa" 
                                        value="{{ $user->data_nascimento ? \Carbon\Carbon::parse($user->data_nascimento)->format('d/m/Y') : '' }}" required>
                                    <label for="nascimento">Data de Nascimento</label>
                                </div>
                            </div>

                            <div class="row">
                                <h6 class="col s12 samca-color-text">3. Preferências e Hábitos</h6>

                                <div class="col s12 m6">
                                    <label>
                                        <input type="checkbox" id="fuma" name="fuma" {{ $user->fuma ? 'checked' : '' }} />
                                        <span>Eu fumo (Moradia deve ser tolerante)</span>
                                    </label>
                                </div>

                                <div class="col s12 m6">
                                    <label>
                                        <input type="checkbox" id="pets" name="pets" {{ $user->pets ? 'checked' : '' }} />
                                        <span>Tenho ou pretendo ter um Pet</span>
                                    </label>
                                </div>

                                <div class="col s12 m6" style="margin-top: 15px;">
                                    <label>
                                        <input type="checkbox" id="silencio" name="silencio" {{ $user->silencio ? 'checked' : '' }} />
                                        <span>Prefiro silêncio absoluto após as 22h</span>
                                    </label>
                                </div>
                                
                                <div class="col s12 m6" style="margin-top: 15px;">
                                    <label>
                                        <input type="checkbox" id="visitas" name="visitas" {{ $user->visitas ? 'checked' : '' }} />
                                        <span>Recebo visitas com frequência</span>
                                    </label>
                                </div>

                                <div class="col s12 m6" style="margin-top: 15px;">
                                    <label>
                                        <input type="checkbox" id="vegetariano" name="vegetariano" {{ $user->vegetariano ? 'checked' : '' }} />
                                        <span>Sou vegetariano(a) ou vegano(a)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="center-align" style="margin-top: 40px; margin-bottom: 20px;">
                                <button class="btn large waves-effect waves-light samca-btn" type="submit">
                                    Salvar e Atualizar Perfil
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </form>
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
            M.FormSelect.init(document.querySelectorAll('select'));
            M.updateTextFields();
            
            const i18n_ptbr = {
                months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                cancel: 'Cancelar',
                clear: 'Limpar',
                done: 'Ok' 
            };
            
            M.Datepicker.init(document.querySelectorAll('.datepicker-mes-ano'), {
                format: 'mmm/yyyy', 
                i18n: i18n_ptbr,
                yearRange: 10,
                autoClose: true
            });
            
            M.Datepicker.init(document.querySelectorAll('.datepicker-data'), {
                format: 'dd/mm/yyyy',
                i18n: i18n_ptbr,
                yearRange: 50,
                maxDate: new Date(),
                autoClose: true
            });
        });
    </script>
</body>
</html>