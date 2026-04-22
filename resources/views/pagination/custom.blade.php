@if ($paginator->hasPages())
<div role="navigation" aria-label="Pagination" class="glowi-pagination">
    <div class="pagination-inner">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn page-btn--disabled" aria-disabled="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn page-btn--nav" rel="prev" aria-label="Page précédente">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-btn page-btn--dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn page-btn--active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn page-btn--nav" rel="next" aria-label="Page suivante">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        @else
            <span class="page-btn page-btn--disabled" aria-disabled="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
        @endif

    </div>
</div>

<style>
.glowi-pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
.pagination-inner {
    display: flex;
    align-items: center;
    gap: 6px;
}
.page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 10px;
    border-radius: 999px;
    font-family: 'Jost', sans-serif;
    font-size: 0.82rem;
    letter-spacing: 0.06em;
    text-decoration: none;
    color: var(--text-light, #7a5c68);
    background: rgba(255,255,255,0.70);
    border: 1px solid rgba(200,116,138,0.14);
    transition: background 0.22s, color 0.22s, border-color 0.22s, transform 0.22s, box-shadow 0.22s;
}
.page-btn:hover {
    background: rgba(200,116,138,0.10);
    color: var(--rose-deep, #a85070);
    border-color: rgba(200,116,138,0.30);
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(200,116,138,0.10);
}
.page-btn--active {
    background: linear-gradient(135deg, var(--rose, #c8748a), var(--rose-deep, #a85070));
    color: #fff !important;
    border-color: transparent;
    box-shadow: 0 8px 20px rgba(200,116,138,0.22);
    font-weight: 600;
    pointer-events: none;
}
.page-btn--disabled {
    opacity: 0.32;
    pointer-events: none;
}
.page-btn--dots {
    background: transparent;
    border-color: transparent;
    pointer-events: none;
    color: var(--text-light, #7a5c68);
}
.page-btn--nav {
    background: rgba(255,255,255,0.80);
}
.page-btn--nav svg {
    width: 16px;
    height: 16px;
}
</style>
@endif