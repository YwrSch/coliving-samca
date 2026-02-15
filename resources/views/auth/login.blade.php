<x-guest-layout>
    <div class="card-panel z-depth-3 login-card">
        
        <h4 class="center-align samca-title">Coliving SAMCA</h4>
        <h5 class="center-align grey-text text-darken-2">Acesse sua Conta</h5>
        <div class="divider"></div>
        <br>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-field">
                <i class="material-icons prefix">email</i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="validate" required autofocus>
                <label for="email">E-mail</label>
                <x-input-error :messages="$errors->get('email')" class="red-text" />
            </div>

            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="password" type="password" name="password" class="validate" required>
                <label for="password">Senha</label>
                <span class="prefix-icon right" style="cursor: pointer;" onclick="togglePasswordVisibility()">
                    <i id="toggle-icon" class="material-icons">visibility</i>
                </span>
                <x-input-error :messages="$errors->get('password')" class="red-text" />
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col s6">
                    <label>
                        <input type="checkbox" name="remember" id="remember" />
                        <span>Lembrar-me</span>
                    </label>
                </div>
                <div class="col s6 right-align">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="samca-link">
                            Esqueceu sua senha?
                        </a>
                    @endif
                </div>
            </div>

            <div class="center-align" style="margin-top: 30px;">
                <button class="btn large waves-effect waves-light samca-btn" type="submit">
                    Entrar
                    <i class="material-icons right">arrow_forward</i>
                </button>
                <br><br>
                <a href="{{ route('register') }}" class="grey-text text-darken-1">
                    Não tem conta? Cadastre-se aqui
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.updateTextFields();
        });

        function togglePasswordVisibility() {
            var senhaInput = document.getElementById('password'); 
            var toggleIcon = document.getElementById('toggle-icon');

            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                senhaInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
    @endpush

</x-guest-layout>