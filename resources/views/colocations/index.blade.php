<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Colocations | Space</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen font-sans">

    <nav class="border-b border-white/5 bg-black/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">C</div>
                <span class="font-bold tracking-tight text-white">ColocShare</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-medium text-gray-500 hover:text-red-400 transition-colors cursor-pointer uppercase tracking-widest">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Mes Colocations</h1>
                <p class="text-gray-500 text-sm">Gérez vos logements et vos dépenses partagées.</p>
            </div>
            <a href="{{ route('colocations.create') }}" class="group relative px-6 py-3 bg-white text-black font-semibold rounded-xl transition-all hover:scale-105 active:scale-95 shadow-xl shadow-white/5">
                + Nouveau Logement
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($colocations as $colocation)
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    
                    <div class="relative bg-[#0f0f0f] border border-white/10 rounded-2xl p-6 flex flex-col h-full shadow-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-2 py-1 bg-blue-500/10 border border-blue-500/20 text-[10px] font-bold text-blue-400 uppercase tracking-tighter rounded">
                                {{ $colocation->pivot->role ?? 'Membre' }}
                            </span>
                            <span class="text-xs text-gray-600">ID: #00{{ $colocation->id }}</span>
                        </div>

                        <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-blue-400 transition-colors">
                            {{ $colocation->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-6 line-clamp-2">
                            {{ $colocation->address }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                            <div class="text-left">
                                <p class="text-[10px] text-gray-600 uppercase font-bold">Loyer Total</p>
                                <p class="text-sm font-semibold text-white">{{ number_format($colocation->price, 2) }} DH</p>
                            </div>
                            
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:bg-blue-600 hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 border-2 border-dashed border-white/5 rounded-3xl flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-2">Aucune colocation trouvée</h3>
                    <p class="text-gray-500 max-w-xs mx-auto mb-8">Vous n'avez pas encore rejoint ou créé de colocation.</p>
                    <a href="{{ route('colocations.create') }}" class="px-8 py-3 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-xl transition-all">
                        Créer ma première colocation
                    </a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>