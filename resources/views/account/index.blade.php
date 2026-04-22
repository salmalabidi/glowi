@extends('layouts.app')

@section('title', 'Mon Profil - Glowi')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="text-gray-600 mt-2">Gérez vos informations personnelles</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche - Photo de profil -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="text-center">
                        <!-- Affichage de la photo -->
                        <div class="relative inline-block">
                            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gradient-to-r from-pink-100 to-purple-100 border-4 border-white shadow-lg">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="Photo de profil" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-pink-400 to-purple-500">
                                        <span class="text-4xl text-white font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Bouton modifier photo -->
                            <button type="button" onclick="openPhotoModal()" 
                                class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md border border-gray-200 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </div>

                        <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500">{{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-400 mt-1">Membre depuis {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>

                    <!-- Statistiques -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex justify-around">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $user->orders_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Commandes</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $user->reviews_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Avis</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $user->wishlists_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Favoris</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Formulaire d'informations -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informations personnelles</h3>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition shadow-md">
                                Mettre à jour mes informations
                            </button>
                        </div>
                    </form>

                    <!-- Section changement de mot de passe -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Changer mon mot de passe</h3>
                        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <button type="submit" 
                                class="w-full bg-gray-800 text-white py-3 rounded-xl font-semibold hover:bg-gray-900 transition">
                                Changer mon mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour la photo de profil -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900">Modifier la photo de profil</h3>
            <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('profile.avatar') }}" method="POST" id="photoForm">
            @csrf
            @method('PATCH')
            
            <div class="mb-4">
                <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">URL de la photo</label>
                <input type="url" name="avatar" id="profile_photo" 
                    placeholder="https://exemple.com/ma-photo.jpg"
                    value="{{ Auth::user()->avatar ?? '' }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                <p class="text-xs text-gray-500 mt-1">Entrez l'URL d'une image (JPG, PNG, GIF)</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition">
                    Enregistrer
                </button>
                @if(Auth::user()->avatar)
                    <button type="button" onclick="deletePhoto()"
                        class="flex-1 bg-red-500 text-white py-3 rounded-xl font-semibold hover:bg-red-600 transition">
                        Supprimer
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
    function openPhotoModal() {
        document.getElementById('photoModal').classList.remove('hidden');
        document.getElementById('photoModal').classList.add('flex');
    }

    function closePhotoModal() {
        document.getElementById('photoModal').classList.add('hidden');
        document.getElementById('photoModal').classList.remove('flex');
    }

    function deletePhoto() {
        if (confirm('Voulez-vous vraiment supprimer votre photo de profil ?')) {
            fetch('{{ route("profile.avatar.delete") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recharger la page pour voir les changements
                    window.location.reload();
                } else {
                    alert('Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression');
            });
        }
    }

    // Fermer le modal en cliquant en dehors
    document.getElementById('photoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePhotoModal();
        }
    });
</script>
@endsection