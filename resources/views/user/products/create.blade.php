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

.image-drop {
    border: 2px dashed rgba(200,116,138,0.28);
    border-radius:16px; padding:28px; text-align:center;
    background:rgba(253,246,240,0.50); cursor:pointer;
    transition:border-color .2s, background .2s;
    position:relative;
}
.image-drop:hover { border-color:var(--rose); background:rgba(200,116,138,0.05); }
.image-drop input[type=file] {
    position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;
}
.image-drop-icon  { font-size:2rem; margin-bottom:8px; }
.image-drop-label { color:var(--text-light); font-size:.88rem; }
.image-drop-label span { color:var(--rose); }
.image-preview { display:none; margin-top:12px; }
.image-preview img { max-height:140px; border-radius:12px; object-fit:cover; }

.btn-submit {
    width:100%; padding:14px; border-radius:999px;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; border:none; font-size:.82rem; letter-spacing:.14em; text-transform:uppercase;
    cursor:pointer; transition:transform .2s, box-shadow .2s;
    margin-top:8px;
}
.btn-submit:hover { transform:translateY(-2px); box-shadow:0 12px 28px rgba(200,116,138,0.26); }

@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
@media (max-width:600px) { .form-row { grid-template-columns:1fr; } }
</style>

<div class="seller-page">
    <a href="{{ route('user.products.index') }}" class="back-link">← Mes annonces</a>

    <div class="page-kicker">Espace vendeur</div>
    <h1 class="page-title">Ajouter un produit</h1>

    <div class="form-card">
        <form method="POST" action="{{ route('user.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}"
                           placeholder="Ex: Crème hydratante Avène" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Marque</label>
                    <input type="text" name="brand" class="form-input" value="{{ old('brand') }}"
                           placeholder="Ex: Bioderma, SVR…">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea"
                          placeholder="Décrivez votre produit en détail…">{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Prix (TND) *</label>
                    <input type="number" name="price" step="0.01" min="0" class="form-input"
                           value="{{ old('price') }}" placeholder="0.00" required>
                    @error('price') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Quantité disponible *</label>
                    <input type="number" name="stock" min="1" class="form-input"
                           value="{{ old('stock', 1) }}" required>
                    @error('stock') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row" style="margin-top:22px">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Catégorie *</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Choisir une catégorie…</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Type de produit</label>
                    <input type="text" name="product_type" class="form-input"
                           value="{{ old('product_type') }}" placeholder="Ex: Soin visage, Maquillage…">
                </div>
            </div>

            <div class="form-group" style="margin-top:22px">
                <label class="form-label">Photo du produit</label>
                <div class="image-drop" id="dropZone">
                    <input type="file" name="image" accept="image/*" id="imageInput">
                    <div class="image-drop-icon">📸</div>
                    <div class="image-drop-label">Cliquez ou glissez une image<br><span>JPG, PNG, WEBP — max 2 Mo</span></div>
                    <div class="image-preview" id="imagePreview">
                        <img id="previewImg" src="" alt="">
                    </div>
                </div>
                @error('image') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-submit">Publier mon annonce</button>
        </form>
    </div>
</div>

<script>
const input = document.getElementById('imageInput');
const preview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');
const dropZone = document.getElementById('dropZone');

input.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            dropZone.querySelector('.image-drop-icon').style.display = 'none';
            dropZone.querySelector('.image-drop-label').style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endsection
