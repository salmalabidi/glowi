@extends('layouts.app')

@section('content')
<style>
:root{
    --rose:#c8748a;
    --rose-deep:#a85070;
    --rose-pale:#f5e6ea;
    --text:#3d2030;
    --text-light:#8a6b77;
    --line:rgba(200,116,138,.16);
}

.chat-page{
    max-width:1200px;
    margin:0 auto;
    padding:56px 28px 90px;
}

.chat-head{
    text-align:center;
    margin-bottom:32px;
}

.chat-title{
    font-family:'Cormorant Garamond',serif;
    font-size:4rem;
    line-height:1;
    color:var(--text);
    margin:0 0 10px;
}

.chat-sub{
    color:var(--text-light);
    font-size:1.05rem;
}

.chat-shell{
    display:grid;
    grid-template-columns:370px 1fr;
    background:#fff;
    border:1px solid var(--line);
    border-radius:34px;
    overflow:hidden;
    min-height:640px;
    box-shadow:0 16px 40px rgba(36,18,25,.06);
}

.contacts-pane{
    border-right:1px solid var(--line);
    background:linear-gradient(180deg,rgba(245,230,234,.3),rgba(255,255,255,1));
}

.pane-title{
    padding:28px 30px 18px;
    font-family:'Cormorant Garamond',serif;
    font-size:2.1rem;
    color:var(--text);
}

.contact-list{
    padding:0 18px 18px;
    display:flex;
    flex-direction:column;
    gap:14px;
}

.contact-card-wrapper{
    position:relative;
}

.contact-card{
    display:flex;
    align-items:center;
    gap:14px;
    padding:16px 52px 16px 18px;
    border:1px solid rgba(200,116,138,.14);
    border-radius:24px;
    text-decoration:none;
    color:inherit;
    background:#fff;
    transition:.2s;
}

.contact-card:hover,
.contact-card.active{
    background:rgba(245,230,234,.6);
    border-color:rgba(200,116,138,.3);
    transform:translateY(-1px);
}

.delete-chat-form{
    position:absolute;
    top:10px;
    right:10px;
    z-index:10;
}

.delete-chat-form button{
    width:28px;
    height:28px;
    border-radius:50%;
    border:1px solid rgba(200,116,138,.2);
    background:#fff;
    color:var(--rose-deep);
    font-size:15px;
    line-height:1;
    cursor:pointer;
    transition:.2s;
}

.delete-chat-form button:hover{
    background:var(--rose-deep);
    color:#fff;
    transform:scale(1.08);
}

.avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--rose),var(--rose-deep));
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:1.6rem;
    position:relative;
    flex-shrink:0;
}

.contact-main{
    min-width:0;
    flex:1;
}

.contact-name{
    font-size:1.05rem;
    font-weight:600;
    color:var(--text);
    margin-bottom:4px;
}

.contact-meta{
    font-size:.85rem;
    color:var(--text-light);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.contact-side{
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    gap:8px;
}

.unread-badge{
    min-width:24px;
    height:24px;
    border-radius:999px;
    background:var(--rose-deep);
    color:#fff;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:.78rem;
    font-weight:700;
    padding:0 7px;
}

.online-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    background:#86d39b;
    border:3px solid #fff;
    position:absolute;
    right:0;
    bottom:0;
}

.discussion-link{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:14px 18px;
    margin:10px 18px 18px;
    border:1px solid rgba(200,116,138,.16);
    border-radius:18px;
    background:rgba(245,230,234,.32);
    text-decoration:none;
    color:var(--text);
}

.discussion-link strong{
    font-size:.95rem;
}

.discussion-link span{
    font-size:.8rem;
    color:var(--text-light);
}

.global-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    background:var(--rose-deep);
    box-shadow:0 0 0 4px rgba(200,116,138,.14);
}

.chat-pane{
    display:flex;
    flex-direction:column;
    min-width:0;
}

.chat-pane-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:26px 30px;
    border-bottom:1px solid var(--line);
}

.chat-pane-head h2{
    font-family:'Cormorant Garamond',serif;
    font-size:2.1rem;
    color:var(--text);
    margin:0;
}

.chat-pane-head span{
    font-size:.92rem;
    color:var(--text-light);
    letter-spacing:.14em;
    text-transform:uppercase;
}

.messages{
    flex:1;
    padding:26px 28px;
    overflow:auto;
    max-height:440px;
    background:#fff;
}

.empty-state{
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:var(--text-light);
    font-size:1rem;
}

.bubble-row{
    display:flex;
    margin-bottom:16px;
}

.bubble-row.mine{
    justify-content:flex-end;
}

.bubble{
    max-width:68%;
    padding:14px 16px;
    border-radius:20px;
    background:rgba(245,230,234,.55);
    color:var(--text);
    border:1px solid rgba(200,116,138,.12);
}

.bubble-row.mine .bubble{
    background:linear-gradient(135deg,var(--rose),var(--rose-deep));
    color:#fff;
    border:none;
}

.bubble-name{
    font-size:.74rem;
    opacity:.85;
    margin-bottom:6px;
}

.bubble-text{
    line-height:1.55;
    word-break:break-word;
}

.bubble-time{
    font-size:.72rem;
    opacity:.75;
    margin-top:8px;
    text-align:right;
}

.chat-form{
    padding:20px 24px;
    border-top:1px solid var(--line);
    background:linear-gradient(180deg,rgba(255,255,255,1),rgba(245,230,234,.2));
}

.form-row{
    display:flex;
    gap:12px;
    align-items:center;
}

.form-row input{
    flex:1;
    border:1px solid rgba(200,116,138,.22);
    background:#fff;
    border-radius:999px;
    padding:15px 18px;
    font-size:.95rem;
    color:var(--text);
    outline:none;
}

.form-row input:focus{
    border-color:rgba(200,116,138,.45);
    box-shadow:0 0 0 4px rgba(200,116,138,.08);
}

.send-btn{
    border:none;
    background:linear-gradient(135deg,var(--rose),var(--rose-deep));
    color:#fff;
    border-radius:999px;
    padding:15px 22px;
    font-size:.82rem;
    font-weight:700;
    letter-spacing:.12em;
    text-transform:uppercase;
    cursor:pointer;
}

.send-btn:disabled{
    opacity:.5;
    cursor:not-allowed;
}

@media (max-width:960px){
    .chat-shell{
        grid-template-columns:1fr;
    }

    .contacts-pane{
        border-right:none;
        border-bottom:1px solid var(--line);
    }

    .chat-title{
        font-size:3rem;
    }
}
</style>

<div class="chat-page">
    <div class="chat-head">
        <h1 class="chat-title">Chat privé</h1>
        <div class="chat-sub">
            Recevez un point de notification quand un nouveau message arrive, et accédez vite à vos discussions.
        </div>
    </div>

    <div class="chat-shell">
        <aside class="contacts-pane">
            <div class="pane-title">Contacts</div>

            <a href="{{ route('chat.index') }}" class="discussion-link">
                <div>
                    <strong>Discussions</strong>
                    <span>Ajoutez ce lien dans votre menu profil</span>
                </div>

                @if($totalUnread > 0)
                    <div class="global-dot"></div>
                @endif
            </a>

            <div class="contact-list" id="contactList">
                @forelse($contacts as $contact)
                    <div class="contact-card-wrapper">
                        <a
                            href="{{ route('chat.index', ['user' => $contact->id]) }}"
                            class="contact-card {{ optional($selectedUser)->id === $contact->id ? 'active' : '' }}"
                            data-user-id="{{ $contact->id }}"
                        >
                            <div class="avatar">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}

                                @if(($contact->unread_count ?? 0) > 0)
                                    <span class="online-dot"></span>
                                @endif
                            </div>

                            <div class="contact-main">
                                <div class="contact-name">{{ $contact->name }}</div>
                                <div class="contact-meta">
                                    {{ $contact->last_message_body ?: 'Aucune discussion pour le moment' }}
                                </div>
                            </div>

                            <div class="contact-side">
                                @if(($contact->unread_count ?? 0) > 0)
                                    <span class="unread-badge">{{ $contact->unread_count }}</span>
                                @endif
                            </div>
                        </a>

                        <form
                            method="POST"
                            action="{{ route('chat.destroy', $contact->id) }}"
                            class="delete-chat-form"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette discussion ?')">
                                ×
                            </button>
                        </form>
                    </div>
                @empty
                    <div style="padding:18px;color:var(--text-light);text-align:center;">
                        Aucune discussion pour le moment.
                    </div>
                @endforelse
            </div>
        </aside>

        <section class="chat-pane">
            <div class="chat-pane-head">
                <h2>{{ $selectedUser?->name ?? 'Choisissez une discussion' }}</h2>
                <span>Conversation privée</span>
            </div>

            <div class="messages" id="messagesBox">
                @if($selectedUser)
                    @forelse($messages as $message)
                        <div class="bubble-row {{ $message->user_id === auth()->id() ? 'mine' : '' }}">
                            <div class="bubble">
                                <div class="bubble-name">{{ $message->sender?->name }}</div>
                                <div class="bubble-text">{{ $message->body }}</div>
                                <div class="bubble-time">{{ $message->created_at?->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="emptyState">
                            Aucun message pour le moment. Lancez la conversation ✨
                        </div>
                    @endforelse
                @else
                    <div class="empty-state" id="emptyState">
                        Sélectionnez un contact pour afficher la conversation.
                    </div>
                @endif
            </div>

            @if($selectedUser)
                <form class="chat-form" id="chatForm">
                    @csrf
                    <input type="hidden" id="recipientId" value="{{ $selectedUser->id }}">

                    <div class="form-row">
                        <input type="text" id="messageInput" placeholder="Écrire un message..." maxlength="2000">
                        <button type="submit" class="send-btn" id="sendBtn">Envoyer</button>
                    </div>
                </form>
            @endif
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
const selectedUserId = {{ $selectedUser?->id ?? 'null' }};
const pollUrl = "{{ route('chat.poll') }}";
const storeUrl = "{{ route('chat.store') }}";
const unreadCountUrl = "{{ route('chat.unread-count') }}";
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

function renderMessages(messages) {
    const box = document.getElementById('messagesBox');
    if (!box) return;

    if (!messages.length) {
        box.innerHTML = '<div class="empty-state" id="emptyState">Aucun message pour le moment. Lancez la conversation ✨</div>';
        return;
    }

    box.innerHTML = messages.map(msg => `
        <div class="bubble-row ${msg.mine ? 'mine' : ''}">
            <div class="bubble">
                <div class="bubble-name">${msg.sender_name ?? ''}</div>
                <div class="bubble-text">${escapeHtml(msg.body)}</div>
                <div class="bubble-time">${msg.time ?? ''}</div>
            </div>
        </div>
    `).join('');

    box.scrollTop = box.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.innerText = text ?? '';
    return div.innerHTML;
}

function updateContactUnread(contacts) {
    contacts.forEach(contact => {
        const card = document.querySelector(`.contact-card[data-user-id="${contact.id}"]`);
        if (!card) return;

        const side = card.querySelector('.contact-side');
        if (!side) return;

        side.innerHTML = contact.unread_count > 0
            ? `<span class="unread-badge">${contact.unread_count}</span>`
            : '';
    });
}

function updateGlobalDiscussionBadge(count) {
    const target = document.querySelector('[data-chat-menu-dot]');
    if (!target) return;

    target.style.display = count > 0 ? 'inline-block' : 'none';
}

async function pollMessages() {
    if (!selectedUserId) return;

    try {
        const response = await fetch(`${pollUrl}?user=${selectedUserId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (!data.success) return;

        renderMessages(data.messages || []);
        updateContactUnread(data.contacts || []);
        updateGlobalDiscussionBadge(data.total_unread || 0);
    } catch (e) {
        console.error('poll error', e);
    }
}

async function refreshUnreadOnly() {
    try {
        const response = await fetch(unreadCountUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            updateGlobalDiscussionBadge(data.count || 0);
        }
    } catch (e) {
        console.error('unread error', e);
    }
}

document.getElementById('chatForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();

    const input = document.getElementById('messageInput');
    const recipientId = document.getElementById('recipientId')?.value;
    const sendBtn = document.getElementById('sendBtn');

    if (!input || !recipientId || !input.value.trim()) return;

    sendBtn.disabled = true;

    try {
        const response = await fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                recipient_id: recipientId,
                body: input.value.trim()
            })
        });

        const data = await response.json();

        if (data.success) {
            input.value = '';
            await pollMessages();
        }
    } catch (e) {
        console.error('send error', e);
    } finally {
        sendBtn.disabled = false;
    }
});

setInterval(() => {
    pollMessages();
    refreshUnreadOnly();
}, 4000);

pollMessages();
refreshUnreadOnly();
</script>
@endsection