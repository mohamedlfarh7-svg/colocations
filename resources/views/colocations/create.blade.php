<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Colocation | Space</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="max-w-md w-full mx-4">
        
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition-colors flex items-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </a>
            <span class="text-xs tracking-widest text-gray-600 uppercase">Step 1 of 1</span>
        </div>

        <div class="relative group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500/30 to-purple-600/30 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-2xl shadow-2xl backdrop-blur-xl">
                
                <h2 class="text-2xl font-semibold bg-linear-to-r from-white to-gray-400 bg-clip-text text-transparent mb-6">
                    Nouvelle Colocation
                </h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                        <ul class="list-disc list-inside text-xs text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('colocations.store') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Titre du logement</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder-gray-600"
                               placeholder="Ex: Appartement à Nador...">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Mensuel (DH)</label>
                        <input type="number" name="price" value="{{ old('price') }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                               placeholder="0.00">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</label>
                        <input type="text" name="address" value="{{ old('address') }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                               placeholder="Hay el Matar, Nador...">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Description</label>
                        <textarea name="description" rows="3" 
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                  placeholder="Détails du logement...">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="w-full mt-4 py-3 bg-white text-black font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300 shadow-lg shadow-white/5 cursor-pointer">
                        Créer maintenant
                    </button>
                </form>

            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-8 text-center">
            @csrf
            <button type="submit" class="text-xs text-gray-600 hover:text-red-500 transition-colors uppercase tracking-widest cursor-pointer">
                Déconnexion
            </button>
        </form>

    </div>

</body>
</html>