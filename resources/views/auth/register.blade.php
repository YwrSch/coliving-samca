<x-guest-layout>
    <div class="card-panel z-depth-3">
        
        <h4 class="center-align samca-title">Coliving SAMCA</h4>
        <h5 class="center-align grey-text text-darken-2">Crie sua Conta</h5>
        <div class="divider"></div>
        <br>

        <form method="POST" action="{{ route('register') }}" id="form-cadastro">
            @csrf

            <input type="hidden" name="role" id="hidden-role" value="estudante">

            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    <label for="name">Nome</label>
                    <x-input-error :messages="$errors->get('name')" class="red-text" />
                </div>
                <div class="input-field col s12 m6">
                    <input id="sobrenome" type="text" name="sobrenome" value="{{ old('sobrenome') }}" required>
                    <label for="sobrenome">Sobrenome</label>
                    <x-input-error :messages="$errors->get('sobrenome')" class="red-text" />
                </div>
            </div>
            
            <div class="input-field">
                <i class="material-icons prefix">phone</i>
                <input id="telefone" type="tel" name="telefone" value="{{ old('telefone') }}" required>
                <label for="telefone">Telefone (DDD + Número)</label>
                <x-input-error :messages="$errors->get('telefone')" class="red-text" />
            </div>
            <div class="input-field">
                <i class="material-icons prefix">email</i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                <label for="email">E-mail</label>
                <x-input-error :messages="$errors->get('email')" class="red-text" />
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">lock</i>
                    <input id="password" type="password" name="password" required>
                    <label for="password">Senha</label>
                    <x-input-error :messages="$errors->get('password')" class="red-text" />
                </div>
                <div class="input-field col s12 m6">
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                    <label for="password_confirmation">Confirmar Senha</label>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="red-text" />
                </div>
            </div>

            <div class="center-align" style="margin-top: 30px;">
                <p class="flow-text">Selecione seu perfil:</p>
                <button class="btn large waves-effect waves-light samca-btn" 
                        type="button" data-perfil="aluno" id="btn-aluno">
                    Cadastrar Aluno
                    <i class="material-icons right">school</i>
                </button>
                <button class="btn large waves-effect waves-light samca-btn-secondary" 
                        type="button" data-perfil="proprietario" id="btn-proprietario">
                    Cadastrar Proprietário
                    <i class="material-icons right">home</i>
                </button>
                
                <br><br>
                <a href="{{ route('login') }}" class="grey-text text-darken-1">Já tem conta? Faça Login</a>
            </div>
        </form>
    </div>

    <div id="modal-confirmacao" class="modal">
        <div class="modal-content center-align">
            <i class="material-icons large samca-color-text" style="font-size: 60px;">help_outline</i>
            <h4>Confirmar Perfil</h4>
            <p>Você está prestes a se cadastrar como **<span id="perfil-selecionado"></span>**.</p>
            <p>Tem certeza desta escolha?</p>
        </div>
        <div class="modal-footer center-align">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancelar</a>
            <button id="btn-confirmar-cadastro" class="waves-effect waves-light btn samca-btn" type="submit">
                Sim, Confirmar
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.updateTextFields();
            var modalElement = document.getElementById('modal-confirmacao');
            var modalInstance = M.Modal.init(modalElement, { dismissible: false });
            
            var form = document.getElementById('form-cadastro');
            var hiddenRole = document.getElementById('hidden-role');
            var perfilSpan = document.getElementById('perfil-selecionado');

            document.getElementById('btn-aluno').addEventListener('click', function() {
                hiddenRole.value = 'estudante';
                perfilSpan.textContent = 'ESTUDANTE';
                modalInstance.open();
            });

            document.getElementById('btn-proprietario').addEventListener('click', function() {
                hiddenRole.value = 'proprietario';
                perfilSpan.textContent = 'PROPRIETÁRIO';
                modalInstance.open();
            });

            document.getElementById('btn-confirmar-cadastro').addEventListener('click', function() {
                form.submit();
            });
        });
    </script>
    @endpush

</x-guest-layout>