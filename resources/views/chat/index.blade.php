@extends('layouts.app')

@section('content')
<style>
:root{--rose:#c8748a;--rose-deep:#a85070;--rose-pale:#f5e6ea;--text:#3d2030;--text-light:#7a5c68;--cream:#fdf6f0;--dark:#24131a;--line:rgba(200,116,138,.14)}
.chat-page{max-width:1220px;margin:0 auto;padding:48px 24px 90px}.chat-title{font-family:'Cormorant Garamond',serif;font-size:4rem;line-height:1;color:var(--text);text-align:center}.chat-sub{color:var(--text-light);text-align:center;margin:10px 0 34px}.chat-shell{display:grid;grid-template-columns:320px 1fr;background:#fff;border:1px solid var(--line);border-radius:28px;overflow:hidden;box-shadow:0 18px 48px rgba(36,19,26,.08)}.chat-sidebar{border-right:1px solid var(--line);padding:24px;background:linear-gradient(180deg,#fff,#fff7fa)}.chat-main{padding:0;display:flex;flex-direction:column;min-height:650px}.side-title{font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--text);margin-bottom:14px}.contact-list{display:flex;flex-direction:column;gap:10px}.contact-item{display:flex;align-items:center;gap:12px;padding:14px;border:1px solid rgba(200,116,138,.12);border-radius:18px;text-decoration:none;color:var(--text);background:#fff;transition:.2s}.contact-item:hover,.contact-item.active{border-color:rgba(200,116,138,.32);background:rgba(200,116,138,.06);transform:translateY(-1px)}.avatar{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--rose),var(--rose-deep));color:#fff;font-weight:700}.contact-meta small{display:block;color:var(--text-light);font-size:.78rem;margin-top:3px}.chat-head{display:flex;align-items:center;justify-content:space-between;padding:22px 24px;border-bottom:1px solid var(--line)}.chat-head h2{font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--text);margin:0}.chat-status{color:var(--text-light);font-size:.82rem;letter-spacing:.12em;text-transform:uppercase}.messages{flex:1;padding:24px;background:linear-gradient(180deg,#fff,#fdf8fa);overflow:auto;display:flex;flex-direction:column;gap:14px}.bubble-wrap{display:flex;flex-direction:column;max-width:72%}.bubble-wrap.me{align-self:flex-end;align-items:flex-end}.bubble-wrap.other{align-self:flex-start;align-items:flex-start}.bubble-user{font-size:.76rem;color:var(--text-light);margin-bottom:4px;letter-spacing:.08em}.bubble{padding:14px 16px;border-radius:20px;background:#fff;border:1px solid rgba(200,116,138,.12);color:var(--text);box-shadow:0 8px 18px rgba(36,19,26,.04)}.bubble-wrap.me .bubble{background:linear-gradient(135deg,var(--rose),var(--rose-deep));color:#fff;border:none}.bubble-time{font-size:.72rem;color:var(--text-light);margin-top:5px}.composer{padding:18px 22px;border-top:1px solid var(--line);background:#fff}.composer form{display:flex;gap:12px}.composer textarea{flex:1;border:1px solid rgba(200,116,138,.18);border-radius:18px;padding:14px 16px;min-height:56px;max-height:140px;resize:vertical;background:#fff;font-family:'Jost',sans-serif}.send-btn{border:none;border-radius:18px;padding:0 24px;background:linear-gradient(135deg,var(--rose),var(--rose-deep));color:#fff;font-weight:600;letter-spacing:.12em;text-transform:uppercase}.empty-chat{margin:auto;text-align:center;color:var(--text-light)}@media(max-width:920px){.chat-shell{grid-template-columns:1fr}.chat-sidebar{border-right:none;border-bottom:1px solid var(--line)}}
</style>
<div class="chat-page">
    <h1 class="chat-title">Chat privé</h1>
    <p class="chat-sub">Discutez en privé entre administrateur et utilisatrices, ou entre toutes les utilisatrices.</p>
    <div class="chat-shell">
        <aside class="chat-sidebar">
            <div class="side-title">Contacts</div>
            <div class="contact-list">
                @foreach($contacts as $contact)
                    <a class="contact-item {{ $selectedUser && $selectedUser->id === $contact->id ? 'active' : '' }}" href="{{ route('chat.index', ['user' => $contact->id]) }}">
                        <div class="avatar">{{ strtoupper(substr($contact->name,0,1)) }}</div>
                        <div class="contact-meta">
                            <div>{{ $contact->name }}</div>
                            <small>{{ $contact->is_admin ? 'Administrateur' : 'Utilisateur' }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </aside>
        <section class="chat-main">
            @if($selectedUser)
                <div class="chat-head">
                    <h2>{{ $selectedUser->name }}</h2>
                    <div class="chat-status">Conversation privée</div>
                </div>
                <div class="messages" id="messagesBox" data-last-id="{{ $messages->last()->id ?? 0 }}" data-user="{{ $selectedUser->id }}">
                    @forelse($messages as $message)
                        <div class="bubble-wrap {{ $message->user_id === auth()->id() ? 'me' : 'other' }}" data-id="{{ $message->id }}">
                            <div class="bubble-user">{{ $message->user_id === auth()->id() ? 'Vous' : ($message->sender->name ?? $selectedUser->name) }}</div>
                            <div class="bubble">{{ $message->body }}</div>
                            <div class="bubble-time">{{ $message->created_at->format('H:i') }}</div>
                        </div>
                    @empty
                        <div class="empty-chat">Aucun message pour le moment. Lancez la conversation ✨</div>
                    @endforelse
                </div>
                <div class="composer">
                    <form id="chatForm" method="POST" action="{{ route('chat.store') }}">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $selectedUser->id }}">
                        <textarea name="body" id="chatBody" placeholder="Écrire un message…" required maxlength="500"></textarea>
                        <button type="submit" class="send-btn">Envoyer</button>
                    </form>
                </div>
            @else
                <div class="empty-chat">Aucun contact disponible.</div>
            @endif
        </section>
    </div>
</div>
@if($selectedUser)
<script>
const box = document.getElementById('messagesBox');
const form = document.getElementById('chatForm');
const bodyInput = document.getElementById('chatBody');
function appendMessage(msg){
    const wrap=document.createElement('div');
    wrap.className='bubble-wrap '+(msg.me?'me':'other');
    wrap.dataset.id=msg.id;
    wrap.innerHTML=`<div class="bubble-user">${msg.me?'Vous':msg.user}</div><div class="bubble">${msg.body}</div><div class="bubble-time">${msg.time}</div>`;
    box.appendChild(wrap); box.dataset.lastId=msg.id; box.scrollTop=box.scrollHeight;
}
box.scrollTop = box.scrollHeight;
form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const fd = new FormData(form);
    const res = await fetch(form.action,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},body:fd});
    if(res.ok){ bodyInput.value=''; }
});
setInterval(async ()=>{
    const since = box.dataset.lastId || 0;
    const user = box.dataset.user;
    const res = await fetch(`{{ route('chat.poll') }}?since=${since}&user=${user}`,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}});
    if(!res.ok) return;
    const data=await res.json();
    data.forEach(appendMessage);
},3000);
</script>
@endif
@endsection
