@extends('layouts.app')

@section('content')
<style>
.admin-page { max-width: 700px; margin: 0 auto; padding: 52px 32px 100px; }
.page-kicker { color: var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); margin-bottom:32px; }
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: var(--rose-deep); font-size: .78rem; letter-spacing: .12em;
    text-transform: uppercase; text-decoration: none; margin-bottom: 24px;
}
.back-link:hover { text-decoration: underline; }

.form-card {
    background: rgba(255,255,255,0.97);
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 26px;
    padding: 36px;
    box-shadow: 0 18px 42px rgba(36,18,25,0.07);
}

.form-group { margin-bottom: 22px; }
.form-label {
    display: block;
    color: var(--text-light);
    font-size: .70rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.form-input {
    width: 100%;
    padding: 12px 18px;
    border-radius: 14px;
    border: 1px solid rgba(200,116,138,0.18);
    background: rgba(253,246,240,0.60);
    color: var(--text);
    font-family: 'Jost', sans-serif;
    font-size: .92rem;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.form-input:focus {
    border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(200,116,138,0.10);
}

.checkbox-row {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    border-radius: 14px;
    border: 1px solid rgba(200,116,138,0.14);
    background: rgba(253,246,240,0.50);
    margin-bottom: 22px;
}
.checkbox-row input[type=checkbox] { width: 18px; height: 18px; accent-color: var(--rose); }
.checkbox-row label { color: var(--text); font-size: .90rem; }

.form-error { color: #a03030; font-size: .82rem; margin-top: 5px; }

.btn-submit {
    width: 100%;
    padding: 14px;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    border: none;
    font-size: .80rem;
    letter-spacing: .14em;
    text-transform: uppercase;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(200,116,138,0.24); }
</style>

<div class="admin-page">
    <a href="{{ route('admin.users.index') }}" class="back-link">← Retour aux utilisateurs</a>

    <div class="page-kicker">Administration</div>
    <h1 class="page-title">Éditer l'utilisateur</h1>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            @if($user->id !== auth()->id())
                <div class="checkbox-row">
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>
                    <label for="is_admin">Administrateur</label>
                </div>
            @endif

            <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        </form>
    </div>
</div>
@endsection
