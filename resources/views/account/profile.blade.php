@extends('layouts.app')

@section('content')
<!-- Ajout indispensable pour que le JS (avatar) puisse communiquer avec Laravel -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.profile-page {
    max-width: 860px;
    margin: 0 auto;
    padding: 50px 48px 100px;
}

.profile-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    font-weight: 300;
    color: var(--text);
    margin-bottom: 8px;
}

.profile-subtitle {
    color: var(--text-light);
    font-size: 0.82rem;
    letter-spacing: 0.08em;
    margin-bottom: 48px;
}

/* AVATAR SECTION */
.profile-avatar-section {
    display: flex;
    align-items: center;
    gap: 32px;
    background: #fff;
    border: 1px solid var(--line-soft);
    border-radius: 16px;
    padding: 32px 36px;
    margin-bottom: 28px;
    box-shadow: 0 4px 20px rgba(200,116,138,0.06);
}

.profile-avatar-preview {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #cf8ca0, #dcb177);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem;
    font-weight: 300;
    color: #fff;
    flex-shrink: 0;
    overflow: hidden;
    border: 3px solid rgba(200,116,138,0.2);
    box-shadow: 0 8px 24px rgba(200,116,138,0.18);
    position: relative;
}

.profile-avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    border-radius: 50%;
}

.avatar-actions {
    flex: 1;
}

.avatar-actions h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    color: var(--text);
    margin-bottom: 6px;
}

.avatar-actions p {
    color: var(--text-light);
    font-size: 0.76rem;
    margin-bottom: 16px;
    line-height: 1.6;
}

.avatar-tabs {
    display: flex;
    gap: 0;
    border: 1px solid var(--line-soft);
    border-radius: 8px;
    overflow: hidden;
    width: fit-content;
    margin-bottom: 14px;
}

.avatar-tab {
    padding: 7px 16px;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    background: transparent;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}

.avatar-tab.active {
    background: var(--rose);
    color: #fff;
}

.avatar-panel { display: none; }
.avatar-panel.active { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

.avatar-url-input {
    flex: 1;
    min-width: 200px;
    background: var(--cream);
    border: 1px solid var(--line-soft);
    border-radius: 8px;
    padding: 9px 14px;
    font-family: 'Jost', sans-serif;
    font-size: 0.8rem;
    color: var(--text);
    outline: none;
    transition: border-color 0.3s;
}

.avatar-url-input:focus { border-color: var(--rose); }

.btn-avatar-apply {
    padding: 9px 20px;
    background: var(--rose);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-family: 'Jost', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
    flex-shrink: 0;
}

.btn-avatar-apply:hover { background: var(--rose-deep); transform: translateY(-1px); }

.btn-avatar-delete {
    padding: 9px 16px;
    background: transparent;
    border: 1px solid rgba(200,116,138,0.3);
    border-radius: 8px;
    color: var(--rose);
    font-family: 'Jost', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    flex-shrink: 0;
}

.btn-avatar-delete:hover { background: rgba(200,116,138,0.08); border-color: var(--rose); }

/* UPLOAD */
.avatar-upload-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 20px;
    background: var(--cream);
    border: 1px dashed rgba(200,116,138,0.4);
    border-radius: 8px;
    color: var(--text-light);
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
}

.avatar-upload-label:hover { background: var(--rose-pale); border-color: var(--rose); color: var(--rose); }
#avatarFileInput { display: none; }

/* FORM CARD */
.profile-card {
    background: #fff;
    border: 1px solid var(--line-soft);
    border-radius: 16px;
    padding: 36px;
    margin-bottom: 28px;
    box-shadow: 0 4px 20px rgba(200,116,138,0.06);
}

.profile-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem;
    color: var(--text);
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--line-soft);
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-card-title span { font-size: 1rem; }

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row.full { grid-template-columns: 1fr; }

.form-group { display: flex; flex-direction: column; gap: 7px; }

.form-label {
    font-size: 0.7rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--text-light);
    font-weight: 500;
}

.form-input {
    background: var(--cream);
    border: 1px solid rgba(200,116,138,0.18);
    border-radius: 10px;
    padding: 12px 16px;
    font-family: 'Jost', sans-serif;
    font-size: 0.88rem;
    color: var(--text);
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-input:focus {
    border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(200,116,138,0.10);
}

.form-input::placeholder { color: var(--text-light); opacity: 0.6; }

.form-hint {
    font-size: 0.7rem;
    color: var(--text-light);
    opacity: 0.7;
    margin-top: 2px;
}

.form-error {
    font-size: 0.72rem;
    color: #e05a6d;
    margin-top: 2px;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 32px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    border: none;
    border-radius: 999px;
    color: #fff;
    font-family: 'Jost', sans-serif;
    font-size: 0.74rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    margin-top: 8px;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px rgba(200,116,138,0.28);
}

.alert-success {
    background: linear-gradient(135deg, rgba(200,116,138,0.08), rgba(201,169,110,0.06));
    border: 1px solid rgba(200,116,138,0.2);
    border-left: 3px solid var(--rose);
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 0.82rem;
    color: var(--rose-deep);
    margin-bottom: 24px;
}

.btn-avatar-delete-red {
    padding: 9px 16px;
    background: rgba(224,90,109,0.1);
    border: 1px solid rgba(224,90,109,0.3);
    border-radius: 8px;
    color: #e05a6d;
    font-family: 'Jost', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
}

.btn-avatar-delete-red:hover { background: rgba(224,90,109,0.2); border-color: #e05a6d; }

@media (max-width: 600px) {
    .profile-page { padding: 30px 20px 60px; }
    .form-row { grid-template-columns: 1fr; }
    .profile-avatar-section { flex-direction: column; text-align: center; }
}
</style>

<div class="profile-page">
    <h1 class="profile-title">Mon profil</h1>
    <p class="profile-subtitle">Gérez vos informations personnelles et votre photo de profil</p>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-success" style="border-left-color:#e05a6d;color:#e05a6d;background:rgba(224,90,109,0.06);">
            @foreach($errors->all() as $error)
                <div>✗ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- AVATAR CARD -->
    <div class="profile-avatar-section">
        <div class="profile-avatar-preview" id="avatarPreview">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Avatar" id="avatarImg">
                <span id="avatarInitial" style="display:none;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            @else
                <span id="avatarInitial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <img id="avatarImg" src="" alt="Avatar" style="display:none;">
            @endif
        </div>

        <div class="avatar-actions">
            <h3>Photo de profil</h3>
            <p>Ajoutez une photo via URL ou depuis votre appareil.</p>

            <div class="avatar-tabs">
                <button class="avatar-tab active" onclick="switchAvatarTab('url', this)" type="button">Lien URL</button>
                <button class="avatar-tab" onclick="switchAvatarTab('upload', this)" type="button">Télécharger</button>
            </div>

            <div class="avatar-panel active" id="panelUrl">
                <input type="text" class="avatar-url-input" id="avatarUrlInput" placeholder="https://..." value="{{ auth()->user()->avatar ?? '' }}">
                <button type="button" class="btn-avatar-apply" onclick="applyAvatarUrl()">Appliquer</button>
                @if(auth()->user()->avatar)
                    <button type="button" class="btn-avatar-delete-red" onclick="deleteAvatar()">🗑 Supprimer</button>
                @endif
            </div>

            <div class="avatar-panel" id="panelUpload">
                <label class="avatar-upload-label" for="avatarFileInput">
                    📁 Choisir un fichier
                </label>
                <input type="file" id="avatarFileInput" accept="image/*" onchange="previewUpload(this)">
                <button type="button" class="btn-avatar-apply" id="btnSaveUpload" style="display:none;" onclick="saveUploadedAvatar()">Sauvegarder</button>
            </div>
        </div>
    </div>

    <!-- INFO CARD -->
    <div class="profile-card">
        <div class="profile-card-title">
            <span>👤</span> Informations personnelles
        </div>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Nom complet</label>
                    <input type="text" class="form-input" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Adresse email</label>
                    <input type="email" class="form-input" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="phone">Téléphone</label>
                    <input type="tel" class="form-input" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                    @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Adresse</label>
                    <input type="text" class="form-input" id="address" name="address" value="{{ old('address', auth()->user()->address ?? '') }}">
                    @error('address')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn-save">✦ Sauvegarder les modifications</button>
        </form>
    </div>

    <!-- PASSWORD CARD -->
    <div class="profile-card">
        <div class="profile-card-title">
            <span>🔒</span> Changer le mot de passe
        </div>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PATCH')
            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label" for="current_password">Mot de passe actuel</label>
                    <input type="password" class="form-input" id="current_password" name="current_password" required>
                    @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">Nouveau mot de passe</label>
                    <input type="password" class="form-input" id="password" name="password" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" class="form-input" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn-save">✦ Mettre à jour le mot de passe</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchAvatarTab(tab, el) {
    document.querySelectorAll('.avatar-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.avatar-panel').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('panel' + tab.charAt(0).toUpperCase() + tab.slice(1)).classList.add('active');
}

function applyAvatarUrl() {
    const url = document.getElementById('avatarUrlInput').value.trim();
    if (!url) {
        alert('Veuillez entrer une URL valide');
        return;
    }
    saveAvatar(url);
}

function previewUpload(input) {
    const file = input.files[0];
    if (!file) return;
    
    // Vérifier le type de fichier
    if (!file.type.startsWith('image/')) {
        alert('Veuillez sélectionner une image (JPG, PNG, GIF)');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        showAvatarPreview(e.target.result);
        document.getElementById('btnSaveUpload').style.display = 'inline-flex';
        document.getElementById('btnSaveUpload').dataset.dataUrl = e.target.result;
    };
    reader.readAsDataURL(file);
}

function saveUploadedAvatar() {
    const dataUrl = document.getElementById('btnSaveUpload').dataset.dataUrl;
    if (dataUrl) saveAvatar(dataUrl);
}

function showAvatarPreview(src) {
    const img = document.getElementById('avatarImg');
    const initial = document.getElementById('avatarInitial');
    if (img) {
        img.src = src;
        img.style.display = 'block';
    }
    if (initial) initial.style.display = 'none';
}

async function saveAvatar(avatarValue) {
    try {
        const res = await fetch('{{ route("profile.avatar") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ avatar: avatarValue })
        });
        const data = await res.json();
        if (data.success) {
            showAvatarPreview(avatarValue);
            // Mettre à jour l'input URL
            const urlInput = document.getElementById('avatarUrlInput');
            if (urlInput) urlInput.value = avatarValue;
            alert('Photo mise à jour avec succès !');
            // Recharger la page pour mettre à jour l'avatar dans la navbar
            setTimeout(() => location.reload(), 500);
        } else {
            alert(data.message || 'Erreur lors de la sauvegarde');
        }
    } catch(e) {
        console.error('Erreur:', e);
        alert('Erreur lors de la sauvegarde');
    }
}

async function deleteAvatar() {
    if (!confirm('Voulez-vous vraiment supprimer votre photo de profil ?')) return;
    
    try {
        const res = await fetch('{{ route("profile.avatar.delete") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await res.json();
        if (data.success) {
            // Réinitialiser l'affichage
            const img = document.getElementById('avatarImg');
            const initial = document.getElementById('avatarInitial');
            const urlInput = document.getElementById('avatarUrlInput');
            
            if (img) {
                img.src = '';
                img.style.display = 'none';
            }
            if (initial) {
                initial.style.display = 'flex';
            }
            if (urlInput) urlInput.value = '';
            
            // Cacher le bouton supprimer
            const deleteBtn = document.querySelector('.btn-avatar-delete-red');
            if (deleteBtn) deleteBtn.style.display = 'none';
            
            alert('Photo supprimée avec succès !');
            setTimeout(() => location.reload(), 500);
        } else {
            alert(data.message || 'Erreur lors de la suppression');
        }
    } catch(e) {
        console.error('Erreur:', e);
        alert('Erreur lors de la suppression');
    }
}
</script>
@endsection