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
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <h2 class="text-2xl font-black text-white mb-6">Ajouter une dépense</h2>
                    <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <form action="{{ route('expenses.store', $colocation) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Libellé (Quoi ?)</label>
                                <input type="text" name="title" placeholder="Ex: Courses Marjane" required
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Montant (DH)</label>
                                <input type="number" step="0.01" name="amount" placeholder="0.00" required
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Catégorie</label>
                                <select name="category_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 transition-all appearance-none text-gray-400">
                                    <option value="">Sélectionner...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-500/20 mt-4 cursor-pointer">
                                Enregistrer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-2xl font-black text-white mb-6">Historique</h2>
                <div class="bg-[#0f0f0f] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/2">
                                <th class="p-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Dépense</th>
                                <th class="p-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Payé par</th>
                                <th class="p-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($colocation->expenses as $expense)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="p-4">
                                    <p class="text-sm font-bold text-white">{{ $expense->title }}</p>
                                    <p class="text-[10px] text-gray-600">{{ $expense->created_at->format('d M, Y') }}</p>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-[10px] text-blue-400 border border-blue-500/20">
                                            {{ substr($expense->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $expense->user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <span class="text-sm font-black text-white">{{ number_format($expense->amount, 2) }} <small class="text-gray-600">DH</small></span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-600 italic text-sm">
                                    Aucune dépense enregistrée pour le moment.
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