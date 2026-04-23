{{-- Exemple de lien à coller dans votre dropdown profil --}}
<a href="{{ route('chat.index') }}" class="menu-link">
    <span>Discussions</span>
    <span class="menu-right">
        <span class="menu-arrow">↗</span>
        <span
            data-chat-menu-dot
            style="
                display:none;
                width:10px;
                height:10px;
                border-radius:999px;
                background:#c8748a;
                box-shadow:0 0 0 4px rgba(200,116,138,.15);
            "
        ></span>
    </span>
</a>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const dot = document.querySelector('[data-chat-menu-dot]');
    if (!dot) return;

    try {
        const response = await fetch('{{ route('chat.unread-count') }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        dot.style.display = data.success && data.count > 0 ? 'inline-block' : 'none';
    } catch (e) {
        console.error('chat menu dot error', e);
    }
});
</script>
