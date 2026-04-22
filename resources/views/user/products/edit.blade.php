@extends('layouts.app')

@section('content')
<style>
.seller-page { max-width: 760px; margin: 0 auto; padding: 52px 32px 100px; }
.page-kicker { color:var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); margin-bottom:32px; }
.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:24px;
}
.back-link:hover { text-decoration:underline; }
.form-card {
    background:rgba(255,255,255,0.97); border:1px solid rgba(200,116,138,0.12);
    border-radius:28px; padding:38px; box-shadow:0 18px 44px rgba(36,18,25,0.07);
    animation: fadeUp .6s ease both;
}
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:22px; }
.form-group { margin-bottom:22px; }
.form-label {
    display:block; color:var(--text-light); font-size:.70rem; letter-spacing:.18em;
    text-transform:uppercase; margin-bottom:8px;
}
.form-input, .form-select, .form-textarea {
    width:100%; padding:12px 18px; border-radius:14px;
    border:1px solid rgba(200,116,138,0.18); background:rgba(253,246,240,0.60);
    color:var(--text); font-family:'Jost',sans-serif; font-size:.92rem; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color:var(--rose); box-shadow:0 0 0 3px rgba(200,116,138,0.10);
}
.form-textarea { resize:vertical; min-height:110px; }
.form-error { color:#a03030; font-size:.82rem; margin-top:5px; }

.current-image {
    display:flex; align-items:center; gap:14px;
    padding:14px 18px; border-radius:14px;
    border:1px solid rgba(200,116,138,0.12); background:rgba(253,246,240,0.50); margin-bottom:14px;
}
.current-image img { width:64px; height:64px; border-radius:10px; object-fit:cover; }
.current-image span { font-size:.84rem; color:var(--text-light); }

.image-drop {
    border:2px dashed rgba(200,116,138,0.28); border-radius:16px; padding:22px;
    text-align:center; background:rgba(253,246,240,0.50); cursor:pointer;
    transition:border-color .2s; position:relative;
}
.image-drop:hover { border-color:var(--rose); }
.image-drop input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.image-drop-label { color:var(--text-light); font-size:.86rem; }
.image-drop-label span { color:var(--rose); }

.btn-submit {
    width:100%; padding:14px; border-radius:999px;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; border:none; font-size:.82rem; letter-spacing:.14em; text-transform:uppercase;
    cursor:pointer; transition:transform .2s, box-shadow .2s; margin-top:8px;
}
.btn-submit:hover { transform:translateY(-2px); box-shadow:0 12px 28px rgba(200,116,138,0.26); }

.btn-danger-outline {
    width:100%; padding:12px; border-radius:999px; margin-top:12px;
    background:transparent; color:#a03030;
    border:1px solid rgba(212,98,98,0.28); font-size:.78rem; letter-spacing:.12em; text-transform:uppercase;
    cursor:pointer; transition:background .2s, transform .2s;
}
.btn-danger-outline:hover { background:rgba(212,98,98,0.08); transform:translateY(-1px); }

@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
@media (max-width:600px) { .form-row { grid-template-columns:1fr; } }
</style>

<div class="seller-page">
    <a href="{{ route('user.products.index') }}" class="back-link">← Mes annonces</a>

    <div class="page-kicker">Espace vendeur</div>
    <h1 class="page-title">Modifier le produit</h1>

    <div class="form-card">
        <form method="POST" action="{{ route('user.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="name" class="form-input"
                           value="{{ old('name', $product->name) }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Marque</label>
                    <input type="text" name="brand" class="form-input" value="{{ old('brand', $product->brand) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Prix (TND) *</label>
                    <input type="number" name="price" step="0.01" min="0" class="form-input"
                           value="{{ old('price', $product->price) }}" required>
                    @error('price') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Quantité disponible *</label>
                    <input type="number" name="stock" min="0" class="form-input"
                           value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            <div class="form-row" style="margin-top:22px">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Catégorie *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Type de produit</label>
                    <input type="text" name="product_type" class="form-input"
                           value="{{ old('product_type', $product->product_type) }}">
                </div>
            </div>

            <div class="form-group" style="margin-top:22px">
                <label class="form-label">Photo du produit</label>
                @if($product->image)
                    <div class="current-image">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="">
                        <span>Image actuelle — remplacez-la en choisissant un nouveau fichier</span>
                    </div>
                @endif
                <div class="image-drop">
                    <input type="file" name="image" accept="image/*">
                    <div class="image-drop-label">
                        Cliquer pour changer l'image<br>
                        <span>JPG, PNG, WEBP — max 2 Mo</span>
                    </div>
                </div>
                @error('image') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        </form>

        {{-- Bouton suppression séparé --}}
        <form method="POST" action="{{ route('user.products.destroy', $product) }}"
              onsubmit="return confirm('Supprimer définitivement ce produit ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-outline">Supprimer ce produit</button>
        </form>
    </div>
</div>
@endsection
