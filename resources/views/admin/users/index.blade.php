@extends('layouts.app')

@section('content')
<style>
.admin-page { max-width: 1200px; margin: 0 auto; padding: 52px 32px 100px; }

.page-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
}
.page-header-left {}
.page-kicker { color: var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); }

.filter-bar {
    display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 22px;
}
.filter-bar input, .filter-bar select {
    padding: 10px 16px;
    border-radius: 999px;
    border: 1px solid rgba(200,116,138,0.18);
    background: rgba(255,255,255,0.92);
    color: var(--text);
    font-family: 'Jost', sans-serif;
    font-size: .86rem;
    outline: none;
    transition: border-color .2s;
}
.filter-bar input:focus, .filter-bar select:focus { border-color: var(--rose); }
.filter-btn {
    padding: 10px 20px;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    border: none;
    font-size: .78rem;
    letter-spacing: .12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
.filter-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(200,116,138,0.22); }

.data-table {
    background: rgba(255,255,255,0.96);
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 18px 42px rgba(36,18,25,0.06);
}
.data-table table { width: 100%; border-collapse: collapse; }
.data-table th {
    background: rgba(200,116,138,0.07);
    color: var(--text-light);
    font-size: .68rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    padding: 14px 20px;
    text-align: left;
    border-bottom: 1px solid rgba(200,116,138,0.10);
}
.data-table td {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(200,116,138,0.06);
    font-size: .90rem;
    color: var(--text);
    vertical-align: middle;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: rgba(200,116,138,0.04); }

.avatar-sm {
    width: 36px; height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(200,116,138,0.20);
}
.avatar-placeholder {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .80rem; font-weight: 600;
}

.status-pill {
    padding: 5px 12px; border-radius: 999px;
    font-size: .64rem; letter-spacing: .14em; text-transform: uppercase; font-weight: 600;
}
.status-admin  { background: rgba(98,184,128,0.14); color: #2f7a47; }
.status-client { background: rgba(200,116,138,0.12); color: var(--rose-deep); }

.action-group { display: flex; gap: 8px; align-items: center; }
.act-btn {
    padding: 6px 13px; border-radius: 999px; font-size: .68rem;
    letter-spacing: .10em; text-transform: uppercase; text-decoration: none;
    border: none; cursor: pointer; transition: transform .2s;
    display: inline-flex; align-items: center;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit   { background: rgba(201,169,110,0.14); color: #7a5a1a; border: 1px solid rgba(201,169,110,0.20); }
.act-danger { background: rgba(212,98,98,0.12);   color: #a03030; border: 1px solid rgba(212,98,98,0.18); }
.act-toggle { background: rgba(200,116,138,0.10); color: var(--rose-deep); border: 1px solid rgba(200,116,138,0.18); }

.alert-success {
    padding: 14px 20px; border-radius: 16px; margin-bottom: 18px;
    background: rgba(98,184,128,0.12); color: #2f7a47;
    border: 1px solid rgba(98,184,128,0.20); font-size: .90rem;
}
.alert-error {
    padding: 14px 20px; border-radius: 16px; margin-bottom: 18px;
    background: rgba(212,98,98,0.12); color: #a03030;
    border: 1px solid rgba(212,98,98,0.20); font-size: .90rem;
}

.pagination-wrap { margin-top: 22px; display: flex; justify-content: center; }

.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: var(--rose-deep); font-size: .78rem; letter-spacing: .12em;
    text-transform: uppercase; text-decoration: none;
    margin-bottom: 24px;
}
.back-link:hover { text-decoration: underline; }
</style>

<div class="admin-page">

    <a href="{{ route('admin.dashboard') }}" class="back-link">← Retour au dashboard</a>

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-kicker">Administration</div>
            <h1 class="page-title">Gestion des utilisateurs</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">✗ {{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="filter-bar">
            <input type="text" name="search" placeholder="Rechercher nom ou email…" value="{{ request('search') }}">
            <select name="role">
                <option value="">Tous les rôles</option>
                <option value="admin"  {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
            </select>
            <button type="submit" class="filter-btn">Filtrer</button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="act-btn act-edit">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                    <th>Commandes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" class="avatar-sm" alt="">
                                @else
                                    <div class="avatar-placeholder">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                @endif
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="status-pill {{ $user->is_admin ? 'status-admin' : 'status-client' }}">
                                {{ $user->is_admin ? 'Admin' : 'Client' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $user->orders()->count() }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="act-btn act-edit">Éditer</a>

                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="act-btn act-toggle">
                                            {{ $user->is_admin ? '→ Client' : '→ Admin' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn act-danger">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-light)">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $users->links('pagination.custom') }}
    </div>
</div>
@endsection
