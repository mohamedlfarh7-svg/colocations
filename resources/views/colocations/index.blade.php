<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Colocations | SpaceColoc</title>
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
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20 italic">S</div>
                <span class="font-black tracking-tighter text-white italic uppercase text-sm">SpaceColoc</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-[10px] font-black text-gray-500 hover:text-red-400 transition-colors cursor-pointer uppercase tracking-[0.2em]">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-[10px] font-black uppercase tracking-widest animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-[10px] font-black uppercase tracking-widest">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-white mb-2 italic tracking-tighter uppercase">Mes Colocations</h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em]">Gérez vos logements et votre réputation.</p>
            </div>

            {{-- Logic: Afficher le bouton seulement si l'utilisateur n'est dans aucune colocation active --}}
            @if(Auth::user()->colocations()->wherePivot('left_at', null)->count() === 0)
                <a href="{{ route('colocations.create') }}" class="group relative px-8 py-4 bg-white text-black font-black rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-white/10 text-[10px] uppercase tracking-[0.2em]">
                    + Nouveau Logement
                </a>
            @else
                <div class="px-8 py-4 bg-white/5 border border-white/10 rounded-2xl opacity-50 cursor-not-allowed flex items-center gap-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] italic">
                        Déjà en colocation
                    </span>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($colocations as $colocation)
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-0 group-hover:opacity-15 transition duration-500"></div>
                    
                    <div class="relative bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 flex flex-col h-full shadow-2xl transition-transform duration-500 group-hover:-translate-y-1">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 bg-white/5 border border-white/10 text-[9px] font-black text-blue-400 uppercase tracking-widest rounded-lg italic">
                                {{ $colocation->pivot->role ?? 'Membre' }}
                            </span>
                            <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest">#{{ str_pad($colocation->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <h3 class="text-2xl font-black text-white mb-3 group-hover:text-blue-400 transition-colors italic tracking-tighter uppercase">
                            {{ $colocation->name }}
                        </h3>
                        
                        <div class="flex items-center gap-2 mb-8">
                            <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest truncate">
                                {{ $colocation->address ?? 'Adresse non spécifiée' }}
                            </p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                            <div>
                                <p class="text-[8px] text-gray-600 uppercase font-black tracking-widest mb-1">Status</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full shadow-[0_0_8px_rgba(34,197,94,0.4)]"></span>
                                    <span class="text-[10px] font-black text-white uppercase italic">Actif</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white/5 border border-white/10 hover:bg-blue-600 hover:border-blue-500 text-white transition-all shadow-xl group/btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 border border-dashed border-white/10 rounded-[2rem] bg-white/[0.01] flex flex-col items-center justify-center text-center shadow-inner">
                    <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mb-8 rotate-3 group hover:rotate-0 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white mb-3 uppercase italic tracking-tighter">Aucun espace trouvé</h3>
                    <p class="text-gray-600 text-[10px] font-bold uppercase tracking-[0.2em] max-w-xs mx-auto mb-10">Vous n'avez pas encore rejoint ou créé de colocation active.</p>
                    
                    @if(Auth::user()->colocations()->wherePivot('left_at', null)->count() === 0)
                        <a href="{{ route('colocations.create') }}" class="px-10 py-4 bg-white/5 border border-white/10 hover:bg-white text-white hover:text-black rounded-2xl transition-all font-black text-[10px] uppercase tracking-[0.2em]">
                            Lancer un projet
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>