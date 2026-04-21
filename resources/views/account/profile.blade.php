@extends('layouts.app')

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 40px 48px 80px;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; color: var(--text); margin-bottom: 12px;">
        Mon profil
    </h1>

    <div style="background: #fff; border: 1px solid rgba(200,116,138,0.14); border-radius: 10px; padding: 28px;">
        <p style="color: var(--text-light); margin-bottom: 10px;"><strong>Nom :</strong> {{ auth()->user()->name }}</p>
        <p style="color: var(--text-light);"><strong>Email :</strong> {{ auth()->user()->email }}</p>
    </div>
</div>
@endsection