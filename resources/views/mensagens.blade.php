<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliving SAMCA - Mensagens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @include('layouts.navigation_aluno')

    <main>
        <div class="container custom-container" style="margin-top: 40px;">
            <div class="row">
                <div class="col s12">
                    <h4><i class="material-icons left samca-color-text">mail</i> Minhas Mensagens</h4>
                    <div class="divider"></div>
                </div>

                <div class="col s12 m10 offset-m1">
                    <ul class="collection z-depth-1">
                        @forelse($conversations as $msg)
                            @php
                                $otherUser = ($msg->from_id == Auth::id()) ? $msg->receiver : $msg->sender;
                                $isUnread = ($msg->to_id == Auth::id() && !$msg->read);
                            @endphp
                            
                            <li class="collection-item avatar collection-item-message {{ $isUnread ? 'message-unread' : '' }} open-chat"
                                data-id="{{ $otherUser->id }}"
                                data-name="{{ $otherUser->name }} {{ $otherUser->sobrenome }}">
                                
                                <i class="material-icons circle samca-btn">person</i>
                                <span class="title"><b>{{ $otherUser->name }} {{ $otherUser->sobrenome }}</b></span>
                                <p class="grey-text truncate">{{ $msg->body }}</p>
                                <span class="secondary-content grey-text">{{ $msg->created_at->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="collection-item center-align" style="padding: 20px;">
                                <p>Nenhuma conversa iniciada.</p>
                                <a href="{{ route('aluno.buscar') }}" class="btn samca-btn">Buscar Moradias</a>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div id="modal-chat" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5 class="samca-color-text">
                    <i class="material-icons left">chat</i>
                    <span id="chat-header-name">Conversa</span>
                </h5>
                <div class="divider"></div>
                <br>
                <div id="chat-body">
                    <div class="center-align grey-text">Carregando mensagens...</div>
                </div>
            </div>
            
            <div class="modal-footer">
                <div class="row" style="margin: 0; display: flex; align-items: center;">
                    
                    <div class="col s3 m2">
                        <a href="#!" class="modal-close btn-flat red-text" style="padding: 0 10px; width: 100%;">
                            <i class="material-icons hide-on-small-only left">close</i>Fechar
                        </a>
                    </div>

                    <div class="input-field col s7 m8" style="margin: 0;">
                        <input id="chat-input" type="text" placeholder="Digite sua resposta..." style="margin-bottom: 0;">
                    </div>

                    <div class="col s2 m2">
                        <button id="btn-chat-enviar" class="btn waves-effect waves-light samca-btn" style="width: 100%; padding: 0;">
                            <i class="material-icons">send</i>
                        </button>
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
            
            // Inicializa o Modal
            var modalChat = M.Modal.init(document.getElementById('modal-chat'), {
                dismissible: false, // O usuário deve clicar em Fechar
                onCloseEnd: function() { location.reload(); } // Atualiza a lista ao fechar
            });

            let currentChatUserId = null;
            const myId = {{ Auth::id() }};

            // Evento de clique na lista
            var chatItems = document.querySelectorAll('.open-chat');
            
            chatItems.forEach(item => {
                item.addEventListener('click', function() {
                    currentChatUserId = this.getAttribute('data-id');
                    let userName = this.getAttribute('data-name');
                    
                    document.getElementById('chat-header-name').innerText = userName;
                    document.getElementById('chat-body').innerHTML = '<div class="center-align" style="margin-top: 20px;"><div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';
                    
                    modalChat.open();
                    carregarMensagens();
                });
            });

            function carregarMensagens() {
                if(!currentChatUserId) return;

                fetch(`/messages/history/${currentChatUserId}`)
                    .then(response => response.json())
                    .then(data => {
                        let chatBody = document.getElementById('chat-body');
                        chatBody.innerHTML = ''; 

                        if(data.length === 0) {
                            chatBody.innerHTML = '<p class="center-align grey-text" style="margin-top:20px;">Nenhuma mensagem ainda.</p>';
                        } else {
                            data.forEach(msg => {
                                let isMe = (msg.from_id == myId);
                                let classe = isMe ? 'chat-me' : 'chat-other';
                                let dataMsg = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                                chatBody.innerHTML += `
                                    <div class="chat-bubble ${classe}">
                                        ${msg.body}
                                        <span class="chat-time">${dataMsg}</span>
                                    </div>
                                `;
                            });
                        }
                        chatBody.scrollTop = chatBody.scrollHeight;
                    })
                    .catch(err => console.error(err));
            }

            document.getElementById('btn-chat-enviar').addEventListener('click', enviarResposta);
            document.getElementById('chat-input').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') enviarResposta();
            });

            function enviarResposta() {
                let input = document.getElementById('chat-input');
                let texto = input.value.trim();
                
                if(texto === '') return;

                let chatBody = document.getElementById('chat-body');
                let now = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                chatBody.innerHTML += `
                    <div class="chat-bubble chat-me" style="opacity: 0.7;">
                        ${texto} <span class="chat-time">${now} ...</span>
                    </div>
                `;
                chatBody.scrollTop = chatBody.scrollHeight;
                input.value = '';

                fetch("{{ route('messages.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        to_id: currentChatUserId,
                        body: texto
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        carregarMensagens();
                    }
                });
            }
        });
    </script>
</body>
</html>