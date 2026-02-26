<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SpaceColoc</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen font-sans pb-12">

    <nav class="border-b border-white/5 bg-black/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">S</div>
                <span class="font-bold tracking-tight text-white">SpaceColoc</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-500 hidden md:block">{{ Auth::user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[10px] font-bold text-red-500/80 hover:text-red-400 uppercase tracking-widest cursor-pointer">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white">Bonjour, {{ Auth::user()->name }} 👋</h1>
                <p class="text-gray-500">Gérez votre logement et surveillez votre réputation.</p>
            </div>
            
            <div class="bg-white/5 border border-white/10 px-6 py-4 rounded-2xl flex items-center gap-4 backdrop-blur-sm">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Ma Réputation</p>
                    <p class="text-2xl font-black {{ Auth::user()->rating >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ Auth::user()->rating > 0 ? '+' : '' }}{{ Auth::user()->rating }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-2xl border border-white/5">
                    {{ Auth::user()->rating >= 0 ? '😇' : '💀' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-[#0f0f0f] border border-white/10 p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1 italic">Mes Logements</p>
                <h2 class="text-3xl font-black text-white">{{ Auth::user()->colocations->count() }}</h2>
            </div>

            <div class="bg-[#0f0f0f] border border-white/10 p-6 rounded-2xl group">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1 italic">Dépenses ce mois</p>
                <h2 class="text-3xl font-black text-green-500">
                    {{ number_format(Auth::user()->expenses()->whereMonth('created_at', now()->month)->sum('amount'), 2) }} <small class="text-xs italic">DH</small>
                </h2>
            </div>

            <div class="bg-linear-to-br from-blue-600 to-indigo-700 p-6 rounded-2xl shadow-xl shadow-blue-500/10 flex flex-col justify-center">
                <p class="text-xs font-bold text-blue-100 uppercase tracking-widest mb-1 italic">Statut global</p>
                <h2 class="text-xl font-bold text-white italic leading-tight">
                    {{ Auth::user()->rating >= 0 ? 'Colocataire exemplaire' : 'Attention aux dettes' }}
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 rounded-2xl overflow-hidden shadow-2xl">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                        <h3 class="font-bold text-white">Mes Colocations Actives</h3>
                        @if(!Auth::user()->colocations()->wherePivot('left_at', null)->exists())
                        <a href="{{ route('colocations.create') }}" class="text-[10px] font-bold uppercase tracking-widest bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-lg transition-all shadow-lg shadow-blue-500/20"> + Créer </a>
                        @endif
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse(Auth::user()->colocations()->wherePivot('left_at', null)->get() as $coloc)
                            <a href="{{ route('colocations.show', $coloc) }}" class="flex items-center justify-between p-6 hover:bg-white/[0.02] transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 font-bold group-hover:bg-blue-500 group-hover:text-white transition-all border border-blue-500/20">
                                        {{ substr($coloc->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:translate-x-1 transition-transform">{{ $coloc->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $coloc->members->count() }} membres actifs</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-gray-600 group-hover:text-white transition-all italic text-xs">
                                    Voir les détails
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        @empty
                            <div class="p-16 text-center">
                                <span class="block text-4xl mb-4">🏠</span>
                                <p class="text-gray-600 text-sm italic">Aucune colocation active pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 p-6 rounded-2xl shadow-xl">
                    <h3 class="font-bold text-white mb-6 text-xs uppercase tracking-[0.2em] border-b border-white/5 pb-4">Actions Rapides</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('colocations.index') }}" class="p-4 bg-white/5 border border-white/5 hover:border-blue-500/50 rounded-2xl text-center transition-all group">
                            <span class="block text-2xl mb-2 group-hover:scale-110 transition-transform">🏘️</span>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Archive</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="p-4 bg-white/5 border border-white/5 hover:border-purple-500/50 rounded-2xl text-center transition-all group">
                            <span class="block text-2xl mb-2 group-hover:scale-110 transition-transform">⚙️</span>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Paramètres</span>
                        </a>
                    </div>
                </div>

                <div class="bg-[#0f0f0f] border border-white/10 p-6 rounded-2xl shadow-xl">
                    <h3 class="font-bold text-white mb-6 text-xs uppercase tracking-[0.2em] border-b border-white/5 pb-4">Activité Récente</h3>
                    <div class="space-y-5">
                        @php
                            $recentExpenses = Auth::user()->expenses()->with('colocation')->latest()->take(3)->get();
                        @endphp
                        @forelse($recentExpenses as $expense)
                            <div class="flex justify-between items-start group">
                                <div>
                                    <p class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors">{{ $expense->description }}</p>
                                    <p class="text-[9px] text-gray-600 uppercase mt-0.5 font-bold tracking-tighter">{{ $expense->colocation->name }}</p>
                                </div>
                                <span class="text-xs font-black text-blue-400 bg-blue-400/5 px-2 py-1 rounded">
                                    {{ number_format($expense->amount, 0) }} DH
                                </span>
                            </div>
                        @empty
                            <p class="text-[10px] text-gray-600 italic text-center py-4">Aucune dépense enregistrée.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-6 text-center text-gray-700 text-[9px] uppercase tracking-[0.3em] mt-20">
        &copy; 2026 SpaceColoc • Powered by Space Labs
    </footer>

</body>
</html>