@extends('layouts.app')

@section('content')
<style>
.cart-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 48px 100px;
}
.cart-header {
    margin-bottom: 32px;
}
.cart-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    color: var(--text);
    font-weight: 400;
}
.cart-subtitle {
    color: var(--text-light);
    margin-top: 8px;
}
.cart-layout {
    display: grid;
    grid-template-columns: 1.6fr 0.8fr;
    gap: 32px;
}
.cart-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.cart-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 18px;
    display: grid;
    grid-template-columns: 110px 1fr auto;
    gap: 18px;
    align-items: center;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.cart-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 32px rgba(200,116,138,0.10);
}
.cart-card.removing {
    opacity: 0;
    transform: translateX(30px);
    transition: all 0.3s ease;
}
.cart-card img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    background: var(--rose-pale);
    border-radius: 6px;
    padding: 10px;
}
.cart-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    color: var(--text);
}
.cart-brand {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-top: 4px;
}
.cart-meta {
    margin-top: 12px;
    display: flex;
    gap: 18px;
    color: var(--text-light);
    font-size: 0.85rem;
    flex-wrap: wrap;
}
.qty-controls {
    margin-top: 14px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--rose-pale);
    padding: 6px;
    border-radius: 999px;
}
.qty-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: var(--rose-deep);
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: none;
    transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
}
.qty-btn:hover {
    transform: translateY(-1px);
    background: var(--rose);
    color: #fff;
}
.qty-value {
    min-width: 22px;
    text-align: center;
    font-weight: 600;
    color: var(--text);
}
.cart-price {
    font-size: 1.1rem;
    color: var(--rose-deep);
    font-weight: 600;
}
.remove-btn {
    margin-top: 12px;
    border: 1px solid rgba(200,116,138,0.2);
    background: transparent;
    color: var(--rose-deep);
    padding: 10px 14px;
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    cursor: none;
    transition: background 0.25s ease, color 0.25s ease, transform 0.25s ease;
}
.remove-btn:hover {
    background: var(--rose);
    color: #fff;
    transform: translateY(-1px);
}
.cart-summary {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 24px;
    height: fit-content;
    position: sticky;
    top: 110px;
}
.summary-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 20px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
    color: var(--text-light);
}
.summary-total {
    display: flex;
    justify-content: space-between;
    margin-top: 18px;
    padding-top: 18px;
    border-top: 1px solid rgba(200,116,138,0.14);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text);
}
.checkout-btn {
    margin-top: 22px;
    width: 100%;
    background: var(--rose);
    color: #fff;
    border: none;
    padding: 14px 18px;
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: none;
}
.empty-cart {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 48px 24px;
    text-align: center;
}
.empty-cart h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 10px;
}
.empty-cart p {
    color: var(--text-light);
    margin-bottom: 20px;
}
.back-shop {
    display: inline-block;
    text-decoration: none;
    background: var(--rose);
    color: #fff;
    padding: 12px 18px;
    border-radius: 6px;
}
#cart-empty-state {
    display: none;
}
@media (max-width: 900px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
    .cart-card {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="cart-page">
    <div class="cart-header">
        <h1 class="cart-title">Mon panier</h1>
        <p class="cart-subtitle">Retrouvez vos produits sélectionnés.</p>
    </div>

    <div id="cart-empty-state" class="empty-cart">
        <h3>Votre panier est vide</h3>
        <p>Ajoutez quelques produits pour commencer.</p>
        <a href="{{ route('products.index') }}" class="back-shop">Continuer mes achats</a>
    </div>

    @if($cart->isEmpty())
        <div class="empty-cart">
            <h3>Votre panier est vide</h3>
            <p>Ajoutez quelques produits pour commencer.</p>
            <a href="{{ route('products.index') }}" class="back-shop">Continuer mes achats</a>
        </div>
    @else
        <div class="cart-layout" id="cart-layout">
            <div class="cart-list" id="cart-list">
                @foreach($cart as $item)
                    <div
                        class="cart-card"
                        data-product-id="{{ $item['id'] }}"
                        data-price="{{ $item['price'] }}"
                        data-subtotal="{{ $item['subtotal'] }}"
                        data-quantity="{{ $item['quantity'] }}"
                    >
                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi' }}"
                             alt="{{ $item['name'] }}">

                        <div>
                            <div class="cart-name">{{ $item['name'] }}</div>
                            <div class="cart-brand">{{ $item['brand'] }}</div>

                            <div class="cart-meta">
                                <span>PU : {{ number_format($item['price'], 2) }} TND</span>
                                <span>Sous-total : <strong class="item-subtotal-inline">{{ number_format($item['subtotal'], 2) }} TND</strong></span>
                            </div>

                            <div class="qty-controls">
                                <button type="button" class="qty-btn" onclick="changeQuantity({{ $item['id'] }}, 'decrease', this)">−</button>
                                <span class="qty-value">{{ $item['quantity'] }}</span>
                                <button type="button" class="qty-btn" onclick="changeQuantity({{ $item['id'] }}, 'increase', this)">+</button>
                            </div>

                            <button
                                type="button"
                                class="remove-btn"
                                onclick="removeFromCart({{ $item['id'] }}, this)">
                                Retirer
                            </button>
                        </div>

                        <div class="cart-price item-subtotal">
                            {{ number_format($item['subtotal'], 2) }} TND
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="cart-summary" id="cart-summary">
                <div class="summary-title">Résumé</div>
                <div class="summary-row">
                    <span>Articles</span>
                    <span id="summary-items">{{ $cart->sum('quantity') }}</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span>Offerte</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span id="summary-total">{{ number_format($total, 2) }} TND</span>
                </div>

               <a href="{{ route('checkout.index') }}" class="checkout-btn" style="display:block;text-align:center;text-decoration:none;">
    Commander
</a>
            </aside>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function formatTnd(value) {
    return Number(value).toFixed(2) + ' TND';
}

function refreshCartStateIfEmpty() {
    const remainingCards = document.querySelectorAll('.cart-card').length;
    if (remainingCards === 0) {
        const layout = document.getElementById('cart-layout');
        const emptyState = document.getElementById('cart-empty-state');
        if (layout) layout.style.display = 'none';
        if (emptyState) emptyState.style.display = 'block';
    }
}

function changeQuantity(productId, action, btn) {
    const card = btn.closest('.cart-card');
    if (!card) return;

    const buttons = card.querySelectorAll('.qty-btn');
    buttons.forEach(button => button.disabled = true);

    fetch(`/cart/${productId}/quantity`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ action })
    })
    .then(async (response) => {
        if (!response.ok) {
            throw new Error('Erreur mise à jour quantité');
        }

        const data = await response.json();

        if (data.removed) {
            card.classList.add('removing');
            setTimeout(() => {
                card.remove();
                document.getElementById('summary-items').textContent = data.count;
                document.getElementById('summary-total').textContent = formatTnd(data.cartTotal);
                updateCartBadge(data.count);
                refreshCartStateIfEmpty();
            }, 280);
            return;
        }

        card.dataset.quantity = data.itemQuantity;
        card.dataset.subtotal = data.itemSubtotal;

        const qtyValue = card.querySelector('.qty-value');
        const subtotalMain = card.querySelector('.item-subtotal');
        const subtotalInline = card.querySelector('.item-subtotal-inline');

        if (qtyValue) qtyValue.textContent = data.itemQuantity;
        if (subtotalMain) subtotalMain.textContent = formatTnd(data.itemSubtotal);
        if (subtotalInline) subtotalInline.textContent = formatTnd(data.itemSubtotal);

        document.getElementById('summary-items').textContent = data.count;
        document.getElementById('summary-total').textContent = formatTnd(data.cartTotal);
        updateCartBadge(data.count);
    })
    .catch(() => {
        alert('Impossible de modifier la quantité pour le moment.');
    })
    .finally(() => {
        buttons.forEach(button => button.disabled = false);
    });
}

function removeFromCart(productId, btn) {
    const card = btn.closest('.cart-card');
    if (!card) return;

    btn.disabled = true;
    btn.textContent = '...';

    fetch(`/cart/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(async (response) => {
        if (!response.ok) {
            throw new Error('Erreur suppression panier');
        }

        const data = await response.json();

        card.classList.add('removing');

        setTimeout(() => {
            card.remove();
            document.getElementById('summary-items').textContent = data.count;

            const totalEl = document.getElementById('summary-total');
            let total = 0;

            document.querySelectorAll('.cart-card').forEach((itemCard) => {
                total += parseFloat(itemCard.dataset.subtotal || 0);
            });

            totalEl.textContent = formatTnd(total);
            updateCartBadge(data.count);
            refreshCartStateIfEmpty();
        }, 280);
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Retirer';
        alert('Impossible de retirer ce produit pour le moment.');
    });
}
</script>
@endsection