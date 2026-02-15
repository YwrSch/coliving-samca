<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Meu Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @include('layouts.navigation_aluno')

    <main>
        <div class="profile-header">
            @if($user->foto)
                <img src="{{ Storage::url($user->foto) }}" alt="Foto de Perfil" class="profile-avatar">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=fff&color=26a69a&size=150" class="profile-avatar">
            @endif
            
            <h3>Bem-vindo(a), {{ explode(' ', $user->name)[0] }}</h3>
            <p class="flow-text grey-text text-darken-1">Seus dados de convivência estão visíveis para facilitar a compatibilidade.</p>
        </div>

        <div class="container custom-container" style="margin-top: 30px;">
            <div class="row">

                <div class="col s12 m5">
                    <div class="compatibility-card center-align z-depth-1">
                        <p class="flow-text samca-color-text">Gerencie seus Dados</p>
                        <p class="grey-text text-darken-1">Mantenha suas informações atualizadas para receber as melhores recomendações.</p>
                        <a href="{{ route('aluno.perfil.editar') }}" class="btn waves-effect waves-light samca-btn-secondary" style="margin-top: 10px;">
                            <i class="material-icons left">edit</i> Editar Dados e Preferências
                        </a>
                    </div>

                    <div class="card-panel z-depth-1" style="margin-top: 20px;">
                        <h5 class="samca-color-text"><i class="material-icons left">face</i> Meus Hábitos</h5>
                        <div class="divider"></div>
                        
                        <div style="margin-top: 15px;">
                            <p>
                                <i class="material-icons tiny left">pets</i> 
                                <strong>Pets:</strong> {{ $user->pets ? 'Tenho/Gosto de animais.' : 'Não tenho/Prefiro sem.' }}
                            </p>
                            
                            <p>
                                <i class="material-icons tiny left">smoking_rooms</i> 
                                <strong>Fumante:</strong> {{ $user->fuma ? 'Fumante (Busco local tolerante).' : 'Não fuma.' }}
                            </p>
                            
                            <p>
                                <i class="material-icons tiny left">volume_off</i> 
                                <strong>Silêncio:</strong> {{ $user->silencio ? 'Prioridade total (Estudos/Sono).' : 'Flexível/Moderado.' }}
                            </p>
                            
                            <p>
                                <i class="material-icons tiny left">restaurant</i> 
                                <strong>Dieta:</strong> {{ $user->vegetariano ? 'Vegetariano/Vegano.' : 'Sem restrições alimentares.' }}
                            </p>
                            
                            <p>
                                <i class="material-icons tiny left">people</i> 
                                <strong>Visitas:</strong> {{ $user->visitas ? 'Gosto de receber visitas.' : 'Prefiro privacidade/Raramente.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col s12 m7">
                    <ul class="collection with-header">
                        <li class="collection-header"><h4>Detalhes Pessoais e Acadêmicos</h4></li>
                        
                        <li class="collection-item">
                            <i class="material-icons left samca-color-text">school</i>
                            <strong>Curso:</strong> {{ strtoupper($user->curso ?? 'Não informado') }}
                            <span class="secondary-content grey-text">UFERSA Angicos</span>
                        </li>
                        
                        <li class="collection-item">
                            <i class="material-icons left samca-color-text">date_range</i>
                            <strong>Ingresso:</strong> {{ $user->ingresso ?? '--/--' }}
                            <span class="secondary-content grey-text">Conclusão: {{ $user->conclusao ?? '--/--' }}</span>
                        </li>
                        
                        <li class="collection-item">
                            <i class="material-icons left samca-color-text">cake</i>
                            <strong>Idade:</strong> 
                            @if($user->data_nascimento)
                                {{ \Carbon\Carbon::parse($user->data_nascimento)->age }} anos
                            @else
                                --
                            @endif
                            <span class="secondary-content grey-text">Gênero: {{ ucfirst($user->genero ?? 'ND') }}</span>
                        </li>
                    </ul>
                    
                    <div class="card-panel z-depth-1" style="display: none;">
                        <h5><i class="material-icons left samca-color-text">rate_review</i> Minhas Avaliações</h5>
                        <div class="divider"></div>
                        
                        <p style="margin-top: 10px;"><strong>Nota Média:</strong> <i class="material-icons tiny amber-text">star</i><i class="material-icons tiny amber-text">star</i><i class="material-icons tiny amber-text">star</i><i class="material-icons tiny amber-text">star</i> (4.8/5.0)</p>
                        
                        <ul class="collection" style="border: none;">
                            <li class="collection-item avatar">
                                <i class="material-icons circle samca-color">comment</i>
                                <span class="title">"Perfil verificado pelo sistema"</span>
                                <p>Usuário ativo desde {{ $user->created_at->format('Y') }}.</p>
                            </li>
                        </ul>
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
        });
    </script>
</body>
</html>