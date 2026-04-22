@extends('layouts.app')

@section('content')
<style>
.wishlist-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 52px 48px 100px;
}

.wishlist-head {
    margin-bottom: 32px;
}

.wishlist-kicker {
    color: var(--rose);
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.wishlist-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5vw, 4rem);
    line-height: 1;
    color: var(--text);
    font-weight: 300;
}

.wishlist-subtitle {
    margin-top: 12px;
    color: var(--text-light);
    line-height: 1.8;
}

.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.wishlist-card {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,255,255,0.94));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: 0 18px 45px rgba(36,18,25,0.06);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.wishlist-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 55px rgba(36,18,25,0.10);
}

.wishlist-image {
    aspect-ratio: 4 / 5;
    overflow: hidden;
    background: linear-gradient(180deg, #fbf1f4 0%, #f6e7eb 100%);
}

.wishlist-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.wishlist-info {
    padding: 18px;
}

.wishlist-cat {
    color: var(--rose);
    font-size: 0.62rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.wishlist-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.25rem;
    color: var(--text);
    margin-bottom: 6px;
}

.wishlist-brand {
    color: var(--text-light);
    font-size: 0.78rem;
    margin-bottom: 10px;
}

.wishlist-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.wishlist-price {
    color: var(--rose-deep);
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
}

.wishlist-actions {
    display: flex;
    gap: 8px;
}

.wishlist-btn {
    border: none;
    padding: 10px 12px;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}

.wishlist-btn:hover {
    transform: translateY(-2px);
}

.wishlist-btn.remove {
    background: rgba(200,116,138,0.10);
    color: var(--rose-deep);
}

.wishlist-btn.cart {
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
}

.empty-wishlist {
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.84));
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 24px;
    padding: 54px 24px;
    text-align: center;
    box-shadow: 0 18px 44px rgba(36,18,25,0.05);
}

.empty-wishlist h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem;
    margin-bottom: 10px;
}

.empty-wishlist p {
    color: var(--text-light);
    margin-bottom: 20px;
}

.shop-btn {
    display: inline-block;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    text-decoration: none;
    padding: 12px 18px;
    border-radius: 14px;
}

@media (max-width: 1000px) {
    .wishlist-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 700px) {
    .wishlist-page {
        padding: 38px 24px 80px;
    }

    .wishlist-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@php
    $wishlistItems = collect($wishlist ?? []);
@endphp

<div class="wishlist-page">
    <div class="wishlist-head">
        <div class="wishlist-kicker">Wishlist</div>
        <h1 class="wishlist-title">Mes favoris</h1>
        <p class="wishlist-subtitle">
            Retrouvez les produits que vous avez mis de côté.
        </p>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="empty-wishlist">
            <h3>Votre wishlist est vide</h3>
            <p>Ajoutez vos produits préférés pour les retrouver ici.</p>
            <a href="{{ route('products.index') }}" class="shop-btn">Découvrir les produits</a>
        </div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlistItems as $product)
                <div class="wishlist-card" id="wishlist-card-{{ $product->id }}">
                    <div class="wishlist-image">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x500/f5e6ea/c8748a?text=Glowi' }}"
                             alt="{{ $product->name }}">
                    </div>

                    <div class="wishlist-info">
                        <div class="wishlist-cat">{{ $product->category->name ?? 'Collection' }}</div>
                        <div class="wishlist-name">{{ $product->name }}</div>
                        <div class="wishlist-brand">{{ $product->brand }}</div>

                        <div class="wishlist-footer">
                            <div class="wishlist-price">{{ number_format($product->price, 2) }} TND</div>

                            <div class="wishlist-actions">
                                <button type="button" class="wishlist-btn remove" onclick="removeFromWishlist({{ $product->id }})">
                                    Retirer
                                </button>

                                <button type="button" class="wishlist-btn cart" onclick="addToCartFromWishlist({{ $product->id }}, this)">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function removeFromWishlist(productId) {
    fetch(`/wishlist/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(async response => {
        if (!response.ok) throw new Error('Erreur wishlist');

        const data = await response.json();
        const card = document.getElementById(`wishlist-card-${productId}`);

        if (card) {
            card.remove();
        }

        if (typeof updateWishlistBadge === 'function') {
            updateWishlistBadge(data.count);
        }

        if (document.querySelectorAll('.wishlist-card').length === 0) {
            location.reload();
        }
    })
    .catch(() => {
        alert('Impossible de retirer ce produit de la wishlist.');
    });
}

function addToCartFromWishlist(productId, btn) {
    btn.textContent = '...';

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(async response => {
        if (!response.ok) throw new Error('Erreur panier');

        const data = await response.json();
        btn.textContent = '✓';

        if (typeof updateCartBadge === 'function') {
            updateCartBadge(data.count);
        }

        setTimeout(() => {
            btn.textContent = '+';
        }, 1200);
    })
    .catch(() => {
        btn.textContent = '+';
    });
}
</script>
@endsection