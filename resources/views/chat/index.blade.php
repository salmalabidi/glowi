@extends('layouts.app')

@section('content')
<style>
:root {
    --rose: #c8748a; --rose-deep: #a85070;
    --text: #3d2030; --text-light: #7a5c68;
    --cream: #fdf6f0;
}

.chat-page {
    max-width: 820px; margin: 0 auto;
    padding: 52px 24px 100px;
    min-height: 100vh;
}

.chat-hero {
    text-align: center; margin-bottom: 28px;
}
.chat-kicker { color:var(--rose); font-size:.68rem; letter-spacing:.26em; text-transform:uppercase; margin-bottom:8px; }
.chat-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2.4rem,5vw,3.6rem); color:var(--text); line-height:1; }
.chat-sub    { color:var(--text-light); margin-top:8px; font-size:.92rem; }

/* Chat window */
.chat-window {
    background: rgba(255,255,255,0.97);
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 28px;
    box-shadow: 0 20px 50px rgba(36,18,25,0.07);
    overflow: hidden;
    display: flex; flex-direction: column;
    height: 520px;
}

.chat-header {
    display: flex; align-items: center; gap: 10px;
    padding: 18px 24px;
    border-bottom: 1px solid rgba(200,116,138,0.10);
    background: rgba(200,116,138,0.04);
}
.chat-header-dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: #62b880; box-shadow: 0 0 0 3px rgba(98,184,128,0.20);
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
.chat-header-title { font-family:'Cormorant Garamond',serif; font-size:1.3rem; color:var(--text); }
.chat-header-count { margin-left:auto; color:var(--text-light); font-size:.78rem; }

/* Messages */
.chat-messages {
    flex: 1; overflow-y: auto; padding: 20px 24px;
    display: flex; flex-direction: column; gap: 12px;
    scroll-behavior: smooth;
}
.chat-messages::-webkit-scrollbar { width: 4px; }
.chat-messages::-webkit-scrollbar-track { background: transparent; }
.chat-messages::-webkit-scrollbar-thumb { background: rgba(200,116,138,0.20); border-radius: 4px; }

.msg-row {
    display: flex; gap: 10px; align-items: flex-end;
    animation: msgIn .25s ease;
}
@keyframes msgIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

.msg-row.me { flex-direction: row-reverse; }

.msg-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .72rem; font-weight: 700;
    flex-shrink: 0;
}

.msg-bubble-wrap { max-width: 68%; }
.msg-name { font-size:.68rem; color:var(--text-light); margin-bottom:3px; letter-spacing:.06em; }
.msg-row.me .msg-name { text-align:right; }

.msg-bubble {
    padding: 11px 16px;
    border-radius: 20px;
    font-size: .92rem; line-height: 1.6; color: var(--text);
    background: rgba(200,116,138,0.07);
    border: 1px solid rgba(200,116,138,0.10);
    word-break: break-word;
}
.msg-row.me .msg-bubble {
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; border-color: transparent;
}

.msg-time {
    font-size:.62rem; color:var(--text-light); margin-top:3px;
    padding: 0 4px;
}
.msg-row.me .msg-time { text-align:right; }

/* Input area */
.chat-input-area {
    padding: 16px 20px;
    border-top: 1px solid rgba(200,116,138,0.10);
    background: rgba(253,246,240,0.60);
}

.chat-form { display: flex; gap: 10px; align-items: center; }

.chat-input {
    flex: 1; padding: 12px 18px;
    border-radius: 999px;
    border: 1px solid rgba(200,116,138,0.20);
    background: rgba(255,255,255,0.95);
    color: var(--text); font-family:'Jost',sans-serif; font-size:.92rem;
    outline: none; transition: border-color .2s, box-shadow .2s;
}
.chat-input:focus { border-color:var(--rose); box-shadow:0 0 0 3px rgba(200,116,138,0.10); }

.chat-send-btn {
    width: 44px; height: 44px; border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
    transition: transform .2s, box-shadow .2s;
}
.chat-send-btn:hover { transform: scale(1.08); box-shadow: 0 8px 20px rgba(200,116,138,0.30); }

/* Login prompt */
.chat-login-prompt {
    padding: 16px 20px; text-align: center;
    border-top: 1px solid rgba(200,116,138,0.10);
    color: var(--text-light); font-size: .88rem;
    background: rgba(253,246,240,0.60);
}
.chat-login-prompt a { color:var(--rose); text-decoration:none; font-weight:500; }
.chat-login-prompt a:hover { text-decoration:underline; }

.empty-chat {
    flex: 1; display:flex; flex-direction:column; align-items:center; justify-content:center;
    color:var(--text-light); font-size:.90rem; gap:10px;
}
.empty-chat-icon { font-size:2.5rem; }
</style>

<div class="chat-page">
    <div class="chat-hero">
        <div class="chat-kicker">Communauté Glowi</div>
        <h1 class="chat-title">Chat public</h1>
        <p class="chat-sub">Échangez avec toutes les utilisatrices en temps réel.</p>
    </div>

    <div class="chat-window">
        <div class="chat-header">
            <div class="chat-header-dot"></div>
            <div class="chat-header-title">Discussion générale</div>
            <div class="chat-header-count" id="msgCount">{{ count($messages) }} messages</div>
        </div>

        <div class="chat-messages" id="chatMessages">
            @if($messages->isEmpty())
                <div class="empty-chat">
                    <div class="empty-chat-icon">💬</div>
                    <span>Soyez la première à écrire un message !</span>
                </div>
            @else
                @foreach($messages as $msg)
                    <div class="msg-row {{ auth()->check() && $msg->user_id === auth()->id() ? 'me' : '' }}"
                         data-id="{{ $msg->id }}">
                        <div class="msg-avatar">{{ strtoupper(substr($msg->user->name, 0, 1)) }}</div>
                        <div class="msg-bubble-wrap">
                            <div class="msg-name">{{ $msg->user->name }}</div>
                            <div class="msg-bubble">{{ $msg->body }}</div>
                            <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @auth
            <div class="chat-input-area">
                <form method="POST" action="{{ route('chat.store') }}" class="chat-form" id="chatForm">
                    @csrf
                    <input type="text" name="body" class="chat-input" id="chatInput"
                           placeholder="Écrire un message…" autocomplete="off" maxlength="500">
                    <button type="submit" class="chat-send-btn" title="Envoyer">➤</button>
                </form>
            </div>
        @else
            <div class="chat-login-prompt">
                <a href="{{ route('login') }}">Connectez-vous</a> pour participer à la discussion.
            </div>
        @endauth
    </div>
</div>

<script>
const chatMessages = document.getElementById('chatMessages');
const chatForm     = document.getElementById('chatForm');
const chatInput    = document.getElementById('chatInput');
const msgCount     = document.getElementById('msgCount');

// Scroll to bottom
function scrollBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
scrollBottom();

// Last message id for polling
let lastId = {{ $messages->last()?->id ?? 0 }};
const isAuth = {{ auth()->check() ? 'true' : 'false' }};

// Build a message row HTML
function buildRow(msg) {
    const cls = msg.me ? 'me' : '';
    const init = msg.user.charAt(0).toUpperCase();
    return `<div class="msg-row ${cls}" data-id="${msg.id}">
        <div class="msg-avatar">${init}</div>
        <div class="msg-bubble-wrap">
            <div class="msg-name">${msg.user}</div>
            <div class="msg-bubble">${msg.body}</div>
            <div class="msg-time">${msg.time}</div>
        </div>
    </div>`;
}

// Poll every 3 seconds
if (isAuth) {
    setInterval(() => {
        fetch(`/chat/poll?since=${lastId}`)
            .then(r => r.json())
            .then(msgs => {
                if (!msgs.length) return;
                // Remove empty state if present
                const empty = chatMessages.querySelector('.empty-chat');
                if (empty) empty.remove();

                msgs.forEach(msg => {
                    chatMessages.insertAdjacentHTML('beforeend', buildRow(msg));
                    lastId = msg.id;
                });

                const total = chatMessages.querySelectorAll('.msg-row').length;
                msgCount.textContent = total + ' message' + (total > 1 ? 's' : '');
                scrollBottom();
            })
            .catch(() => {});
    }, 3000);
}

// Submit via Enter
if (chatInput) {
    chatInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (chatInput.value.trim()) chatForm.submit();
        }
    });
}

// Scroll after submit
if (chatForm) {
    chatForm.addEventListener('submit', () => {
        setTimeout(scrollBottom, 400);
    });
}
</script>
@endsection
