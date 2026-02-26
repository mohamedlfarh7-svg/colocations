<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $colocation->name }} | Space</title>
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
                Mes Colocations
            </a>
            <div class="flex items-center gap-4">
                @can('update', $colocation)
                    <a href="{{ route('colocations.edit', $colocation) }}" class="text-xs font-bold text-blue-500 hover:underline uppercase tracking-widest">Modifier</a>
                @endcan
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 lg:p-12">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative mb-12 group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6 shadow-2xl">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-black text-white mb-2">{{ $colocation->name }}</h1>
                    <p class="text-gray-500 flex items-center justify-center md:justify-start gap-2 text-sm uppercase tracking-widest">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Espace Actif
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-center min-w-[160px]">
                        <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1 font-bold">Total Dépensé</span>
                        <span class="text-2xl font-black text-blue-500">{{ number_format($totalExpenses, 2) }} <small class="text-xs">DH</small></span>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-center min-w-[160px]">
                        <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1 font-bold">Ma Part</span>
                        <span class="text-2xl font-black text-purple-500">{{ number_format($sharePerMember, 2) }} <small class="text-xs">DH</small></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 mb-8 shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="w-2 h-8 bg-purple-600 rounded-full"></div>
                    Galerie Privée
                </h3>
                <form action="{{ route('colocations.images.store', $colocation) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" id="image_upload" class="hidden" onchange="this.form.submit()">
                    <label for="image_upload" class="bg-white/5 border border-white/10 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-white/10 cursor-pointer transition-all uppercase tracking-widest">
                        + Ajouter une photo
                    </label>
                </form>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($colocation->images as $image)
                    <div class="aspect-square rounded-2xl overflow-hidden border border-white/5 group relative">
                        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                             <span class="text-[10px] font-bold uppercase tracking-tighter">Voir</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center border border-dashed border-white/10 rounded-2xl">
                        <p class="text-gray-600 text-sm">Aucune photo de l'appartement pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                        <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                        Membres & Équilibre
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($balances as $item)
                            <div class="bg-white/2 border border-white/5 p-5 rounded-2xl flex justify-between items-center hover:border-white/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-xs font-bold border border-white/10 text-white shadow-lg uppercase">
                                        {{ substr($item['user']->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $item['user']->name }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase">{{ $item['user']->id == Auth::id() ? 'Moi' : 'Coloc' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[9px] text-gray-500 uppercase mb-1">Balance</span>
                                    <span class="text-sm font-black {{ $item['balance'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $item['balance'] >= 0 ? '+' : '' }}{{ number_format($item['balance'], 2) }} DH
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-linear-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-lg shadow-blue-500/20 hover:scale-[1.01] transition-transform">
                    <div>
                        <h4 class="text-xl font-bold text-white">Gestion des Dépenses</h4>
                        <p class="text-blue-100 text-sm">Ajoutez de nouveaux achats ou consultez l'historique complet.</p>
                    </div>
                    <a href="{{ route('expenses.index', $colocation) }}" class="bg-white text-blue-600 px-8 py-3 rounded-xl font-bold text-sm hover:bg-gray-100 transition-all cursor-pointer whitespace-nowrap">
                        Gérer les achats
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                @can('update', $colocation)
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl">
                    <h3 class="text-lg font-bold text-white mb-6">Inviter un coloc</h3>
                    <form action="{{ route('invitations.store', $colocation) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 block tracking-widest">Email du nouveau membre</label>
                            <input type="email" name="email" placeholder="coloc@exemple.com" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all text-white placeholder-gray-700" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-600/20 cursor-pointer">
                            Envoyer l'invitation
                        </button>
                    </form>
                </div>
                @endcan

                <div class="p-6 border border-white/5 bg-white/2 rounded-2xl text-center">
                    <p class="text-[10px] text-gray-500 italic uppercase tracking-widest">
                        "Les bons comptes font <br> les bons colocs."
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>