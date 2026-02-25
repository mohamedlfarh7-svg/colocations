<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer {{ $colocation->title }} | Space</title>
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
            <a href="{{ route('colocations.index') }}" class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('colocations.edit', $colocation) }}" class="text-xs font-bold text-blue-500 hover:underline uppercase tracking-widest">Modifier</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 lg:p-12">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="relative mb-12 group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6 shadow-2xl">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-black text-white mb-2">{{ $colocation->title }}</h1>
                    <p class="text-gray-500 flex items-center justify-center md:justify-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {{ $colocation->address }}
                    </p>
                </div>
                <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-center min-w-[200px]">
                    <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1 font-bold">Dépenses Totales</span>
                    <span class="text-3xl font-black text-blue-500">{{ number_format($totalExpenses ?? 0, 2) }} <small class="text-xs uppercase">DH</small></span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                        <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                        Membres & Soldes
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($balances as $item)
                            <div class="bg-white/5 border border-white/5 p-5 rounded-2xl flex justify-between items-center group hover:border-white/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-gray-700 to-gray-900 flex items-center justify-center text-xs font-bold border border-white/10">
                                        {{ substr($item['user']->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $item['user']->name }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase">{{ $item['user']->id == Auth::id() ? 'Moi' : 'Membre' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black {{ $item['balance'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $item['balance'] >= 0 ? '+' : '' }}{{ number_format($item['balance'], 2) }} DH
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-linear-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-lg shadow-blue-500/20">
                    <div>
                        <h4 class="text-xl font-bold text-white">Une nouvelle dépense ?</h4>
                        <p class="text-blue-100 text-sm">Mettez à jour les comptes instantanément.</p>
                    </div>
                    <a href="{{ route('expenses.index', ['colocation' => $colocation->id]) }}" class="bg-white text-blue-600 px-8 py-3 rounded-xl font-bold text-sm hover:scale-105 transition-all cursor-pointer">
                        Ajouter Dépense
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl relative overflow-hidden">
                    <h3 class="text-lg font-bold text-white mb-6">Inviter un coloc</h3>
                    <form action="{{ route('invitations.store', $colocation) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 block tracking-widest">Email de l'utilisateur</label>
                            <input type="email" name="email" placeholder="coloc@exemple.com" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-700 text-white" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 cursor-pointer shadow-lg shadow-blue-600/20">
                            Envoyer
                        </button>
                    </form>

                    @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
                        <div class="mt-8 pt-6 border-t border-white/5">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Invitations en attente</h4>
                            <div class="space-y-3">
                                @foreach($pendingInvitations as $invite)
                                    <div class="flex justify-between items-center bg-white/2 p-3 rounded-lg border border-white/5">
                                        <span class="text-xs text-gray-400 truncate max-w-[120px]">{{ $invite->email }}</span>
                                        <span class="text-[9px] px-2 py-0.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 rounded-full uppercase font-bold">Pending</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-6 border border-white/5 bg-white/2 rounded-2xl">
                    <p class="text-xs text-gray-500 italic text-center uppercase tracking-tighter">
                        "Les bons comptes font <br> les bons colocs."
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>