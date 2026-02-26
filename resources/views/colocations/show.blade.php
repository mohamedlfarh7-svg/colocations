<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $colocation->name }} | SpaceColoc</title>
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
                    <a href="{{ route('colocations.edit', $colocation) }}" class="text-[10px] font-bold text-blue-500/80 hover:text-blue-400 uppercase tracking-[0.2em]">Modifier</a>
                @endcan
                <form action="{{ route('colocations.leave', $colocation) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment quitter cette colocation ? Votre réputation sera mise à jour.')">
                    @csrf
                    <button type="submit" class="text-[10px] font-bold text-red-500/80 hover:text-red-400 uppercase tracking-[0.2em] cursor-pointer italic">Quitter</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 lg:p-12">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative mb-12 group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6 shadow-2xl">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-black text-white mb-2 tracking-tighter italic">{{ $colocation->name }}</h1>
                    <p class="text-gray-500 flex items-center justify-center md:justify-start gap-2 text-[10px] font-bold uppercase tracking-widest">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]"></span>
                        Espace Actif • {{ $colocation->members->count() }} Membres
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-center min-w-[160px] backdrop-blur-sm">
                        <span class="block text-[9px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-black italic">Dépenses Totales</span>
                        <span class="text-2xl font-black text-blue-500">{{ number_format($totalExpenses, 0) }} <small class="text-xs uppercase">DH</small></span>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-center min-w-[160px] backdrop-blur-sm">
                        <span class="block text-[9px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-black italic">Part Individuelle</span>
                        <span class="text-2xl font-black text-purple-500">{{ number_format($sharePerMember, 0) }} <small class="text-xs uppercase">DH</small></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 mb-8 shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-black text-white flex items-center gap-3 italic uppercase tracking-tighter">
                    <div class="w-1.5 h-6 bg-purple-600 rounded-full"></div>
                    Galerie Privée
                </h3>
                <form action="{{ route('colocations.images.store', $colocation) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" id="image_upload" class="hidden" onchange="this.form.submit()">
                    <label for="image_upload" class="bg-white/5 border border-white/10 text-white px-5 py-2.5 rounded-xl text-[10px] font-black hover:bg-white/10 cursor-pointer transition-all uppercase tracking-[0.2em]">
                        + Nouvelle Photo
                    </label>
                </form>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($colocation->images as $image)
                    <div class="aspect-square rounded-2xl overflow-hidden border border-white/5 group relative">
                        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center p-4">
                             <span class="text-[9px] font-black uppercase tracking-widest text-white italic">Agrandir</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center border border-dashed border-white/5 rounded-2xl bg-white/[0.01]">
                        <p class="text-gray-600 text-[10px] uppercase font-bold tracking-widest italic">Aucun souvenir partagé</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl">
                    <h3 class="text-xl font-black text-white mb-8 flex items-center gap-3 italic uppercase tracking-tighter">
                        <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                        Membres & Réputation
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @foreach($balances as $item)
                            <div class="bg-white/[0.03] border border-white/5 p-5 rounded-2xl flex justify-between items-center group hover:border-blue-500/30 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-linear-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-xs font-black border border-white/10 text-white shadow-lg uppercase">
                                            {{ substr($item['user']->name, 0, 2) }}
                                        </div>
                                        <div class="absolute -top-2 -right-2 px-1.5 py-0.5 rounded-md text-[8px] font-black {{ $item['user']->rating >= 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                            {{ $item['user']->rating > 0 ? '+' : '' }}{{ $item['user']->rating }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-white uppercase italic tracking-tighter">{{ $item['user']->name }}</p>
                                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">{{ $item['user']->id == Auth::id() ? 'Moi (Actif)' : 'Membre' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[8px] text-gray-600 font-black uppercase tracking-[0.2em] mb-1">Balance</span>
                                    <span class="text-sm font-black {{ $item['balance'] >= 0 ? 'text-green-400' : 'text-red-400' }} italic">
                                        {{ $item['balance'] >= 0 ? '+' : '' }}{{ number_format($item['balance'], 0) }} DH
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-8 border-t border-white/5">
                        <h4 class="text-[10px] font-black text-gray-500 mb-6 uppercase tracking-[0.3em] italic text-center">Régler une dette (Settle Up)</h4>
                        <form action="{{ route('payments.store', $colocation) }}" method="POST" class="flex flex-wrap gap-4 justify-center">
                            @csrf
                            <select name="to_user_id" class="flex-1 min-w-[200px] bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-green-500 transition-all uppercase tracking-widest" required>
                                <option value="" class="bg-[#0f0f0f]">Rembourser un coloc</option>
                                @foreach($colocation->members->where('id', '!=', Auth::id()) as $member)
                                    <option value="{{ $member->id }}" class="bg-[#0f0f0f]">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="amount" step="0.01" placeholder="Montant" class="w-32 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-green-500 transition-all text-center" required>
                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white px-8 py-3 rounded-xl font-black text-[10px] transition-all shadow-lg shadow-green-600/20 cursor-pointer uppercase tracking-[0.2em]">
                                Confirmer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-linear-to-r from-blue-600 to-indigo-800 rounded-3xl p-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-2xl group overflow-hidden relative">
                    <div class="relative z-10">
                        <h4 class="text-xl font-black text-white italic uppercase tracking-tighter">Gestion des Achats</h4>
                        <p class="text-blue-100 text-xs font-medium opacity-80 uppercase tracking-widest">Suivez chaque centime dépensé en groupe.</p>
                    </div>
                    <a href="{{ route('expenses.index', $colocation) }}" class="relative z-10 bg-white text-blue-600 px-8 py-4 rounded-2xl font-black text-[10px] hover:scale-105 transition-all whitespace-nowrap uppercase tracking-[0.2em] shadow-xl">
                        Historique complet
                    </a>
                    <div class="absolute right-0 bottom-0 opacity-10 translate-y-1/2 translate-x-1/4 group-hover:scale-110 transition-transform">
                        <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @can('update', $colocation)
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-8 shadow-xl">
                    <h3 class="text-sm font-black text-white mb-6 uppercase tracking-[0.2em] italic">Inviter un coloc</h3>
                    <form action="{{ route('invitations.store', $colocation) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="text-[9px] font-black text-gray-600 uppercase mb-2 block tracking-[0.2em]">Adresse Email</label>
                            <input type="email" name="email" placeholder="coloc@exemple.com" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold focus:outline-none focus:border-blue-500 transition-all text-white placeholder-gray-800" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-4 rounded-xl font-black text-[10px] transition-all shadow-lg shadow-blue-600/20 cursor-pointer uppercase tracking-[0.2em]">
                            Envoyer le mail
                        </button>
                    </form>
                </div>
                @endcan

                <div class="p-8 border border-white/5 bg-white/[0.01] rounded-3xl text-center shadow-inner">
                    <div class="text-2xl mb-3">⚖️</div>
                    <p class="text-[9px] text-gray-600 italic uppercase font-black tracking-[0.3em] leading-loose">
                        Un colocataire avec un bon score est un colocataire qui ne part jamais avec des dettes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>