<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépenses | Space</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen font-sans">

    <nav class="border-b border-white/5 bg-black/50 backdrop-blur-md sticky top-0 z-50 px-6 h-16 flex justify-between items-center">
        <a href="{{ route('colocations.show', $colocation) }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Retour au Dashboard
        </a>
        <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-500">Gestion des Flux</span>
    </nav>

    <main class="max-w-6xl mx-auto p-6 lg:p-12">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <h2 class="text-2xl font-black text-white mb-6 italic">Ajouter une dépense</h2>
                    <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <form action="{{ route('expenses.store', $colocation) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Libellé</label>
                                <input type="text" name="title" placeholder="Ex: Courses Marjane" required
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all text-white">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Montant (DH)</label>
                                <input type="number" step="0.01" name="amount" placeholder="0.00" required
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all text-white">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Catégorie</label>
                                <select name="category" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all text-gray-300 appearance-none">
                                    <option value="" disabled selected>Choisir une catégorie</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" class="bg-[#0f0f0f]">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-500/20 mt-4 cursor-pointer uppercase text-xs tracking-widest">
                                Enregistrer la dépense
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-2xl font-black text-white mb-6 italic">Historique des transactions</h2>
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/2 border-b border-white/5">
                                <th class="p-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Dépense</th>
                                <th class="p-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Payé par</th>
                                <th class="p-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-right">Montant</th>
                                <th class="p-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($expenses as $expense)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-5">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-bold text-white">{{ $expense->title }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[9px] bg-blue-500/10 text-blue-400 px-1.5 py-0.5 rounded border border-blue-500/20 uppercase font-bold tracking-tighter">
                                                {{ $expense->category }}
                                            </span>
                                            <span class="text-[10px] text-gray-600 uppercase tracking-tighter">{{ $expense->created_at->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-blue-600/20 flex items-center justify-center text-[10px] font-bold text-blue-400 border border-blue-500/10">
                                            {{ substr($expense->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $expense->user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right">
                                    <span class="text-sm font-black text-blue-500">{{ number_format($expense->amount, 2) }} <small class="text-[10px] opacity-50">DH</small></span>
                                </td>
                                <td class="p-5 text-center">
                                    <form action="{{ route('expenses.destroy', [$colocation, $expense]) }}" method="POST" onsubmit="return confirm('Supprimer cette dépense ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-600 hover:text-red-500 transition-colors p-2 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center">
                                    <p class="text-gray-600 italic text-sm">Aucune donnée pour le moment.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>