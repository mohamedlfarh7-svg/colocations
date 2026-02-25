<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Colocation | Space</title>
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
            <a href="{{ route('colocations.index') }}" class="text-gray-500 hover:text-white transition-colors flex items-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Annuler
            </a>
            <span class="text-xs tracking-widest text-blue-500 uppercase font-medium">Modification</span>
        </div>

        <div class="relative group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-yellow-500/20 to-orange-600/20 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-2xl shadow-2xl backdrop-blur-xl">
                
                <h2 class="text-2xl font-semibold bg-linear-to-r from-white to-gray-400 bg-clip-text text-transparent mb-6">
                    Modifier les infos
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

                <form action="{{ route('colocations.update', $colocation) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</label>
                        <input type="text" name="title" value="{{ old('title', $colocation->title) }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Prix (DH)</label>
                        <input type="number" name="price" value="{{ old('price', $colocation->price) }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</label>
                        <input type="text" name="address" value="{{ old('address', $colocation->address) }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Description</label>
                        <textarea name="description" rows="3" 
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all">{{ old('description', $colocation->description) }}</textarea>
                    </div>

                    <button type="submit" class="w-full mt-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-500 transition-all duration-300 shadow-lg shadow-blue-500/20 cursor-pointer">
                        Mettre à jour
                    </button>
                </form>

            </div>
        </div>

        <div class="mt-10 p-4 border border-red-500/20 bg-red-500/5 rounded-2xl flex items-center justify-between">
            <div class="text-left">
                <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Zone de danger</p>
                <p class="text-[10px] text-gray-500">Supprimer définitivement cette colocation</p>
            </div>
            <form action="{{ route('colocations.destroy', $colocation) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-bold rounded-lg transition-all cursor-pointer border border-red-500/20">
                    Supprimer
                </button>
            </form>
        </div>

    </div>

</body>
</html>