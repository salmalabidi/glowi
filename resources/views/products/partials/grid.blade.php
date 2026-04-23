@forelse($products as $index => $product)
   @php
    $imagePath = $product->image ?? '';

    if ($imagePath) {
        if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
            $imageUrl = $imagePath;
        } elseif (\Illuminate\Support\Str::startsWith($imagePath, ['Images/', 'images/'])) {
            $imageUrl = asset($imagePath);
        } else {
            $imageUrl = asset('storage/' . $imagePath);
        }
    } else {
        $imageUrl = 'https://via.placeholder.com/400x500/f5e6ea/c8748a?text=' . urlencode($product->name);
    }
@endphp

    <div class="product-card fade-up" style="animation-delay: {{ $index * 0.05 }}s">
        <div class="product-img-wrap">
            @if($loop->index < 3)
                <span class="product-badge">Nouveau</span>
            @endif

            <img
                src="{{ $imageUrl }}"
                alt="{{ $product->name }}"
                onerror="this.src='https://via.placeholder.com/400x500/f5e6ea/c8748a?text={{ urlencode($product->name) }}'"
            >

            <div class="product-overlay">
                <a href="{{ route('products.show', $product) }}" class="overlay-btn">Voir</a>

                @auth
                    <button class="wishlist-btn" onclick="toggleWishlist({{ $product->id }}, this)">♡</button>
                @endauth
            </div>
        </div>

        <div class="product-info">
            <div class="product-cat">
                {{ $product->category->name ?? '' }}{{ $product->product_type ? ' — ' . $product->product_type : '' }}
            </div>

            <div class="product-name">{{ $product->name }}</div>
            <div class="product-brand">{{ $product->brand }}</div>

            <div class="product-footer">
                <div class="product-price">{{ number_format($product->price, 2) }} TND</div>

                @auth
                    <button class="add-mini" onclick="addToCart({{ $product->id }}, this)">+</button>
                @endauth
            </div>
        </div>
    </div>
@empty
    <div class="empty-state">
        <div class="icon">✦</div>
        <h3>Aucun produit trouvé</h3>
        <p>Essayez d'autres filtres ou termes de recherche.</p>
    </div>
@endforelse