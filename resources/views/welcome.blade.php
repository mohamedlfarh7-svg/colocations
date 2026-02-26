<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceColoc | Gestion de Colocation</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen font-sans">

    <nav class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20 italic">S</div>
            <span class="font-black tracking-tighter text-white italic uppercase text-sm">SpaceColoc</span>
        </div>
        <div class="flex items-center gap-6">
            @auth
                <a href="{{ route('colocations.index') }}" class="text-[10px] font-black text-white uppercase tracking-widest hover:text-blue-400 transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-[10px] font-black text-gray-500 uppercase tracking-widest hover:text-white transition-colors">Connexion</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-white text-black text-[10px] font-black uppercase tracking-widest rounded-lg hover:scale-105 transition-all">S'inscrire</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-20 pb-12 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-black uppercase tracking-[0.2em] mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            Nouvelle génération de gestion
        </div>

        <h1 class="text-5xl md:text-7xl font-black text-white italic tracking-tighter uppercase mb-6">
            Gérez votre coloc <br> <span class="text-blue-600">sans stress.</span>
        </h1>
        <p class="text-gray-500 text-sm md:text-base font-medium max-w-2xl mx-auto mb-10 leading-relaxed">
            Partagez vos dépenses, gérez vos tâches et gardez une réputation irréprochable au sein de votre communauté.
        </p>

        <div class="flex flex-wrap justify-center gap-4 mb-20">
            <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl text-[11px] uppercase tracking-[0.2em] hover:bg-blue-500 hover:scale-105 transition-all shadow-2xl shadow-blue-600/20">
                + Créer une Colocation
            </a>
            <a href="{{ route('login') }}" class="px-8 py-4 border border-white/10 bg-white/5 text-white font-black rounded-2xl text-[11px] uppercase tracking-[0.2em] hover:bg-white/10 transition-all">
                Rejoindre un groupe
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <div class="p-8 bg-[#0f0f0f] border border-white/10 rounded-[2rem] text-left">
               
                <h3 class="text-white font-black uppercase italic text-sm mb-2">Dépenses Partagées</h3>
                <p class="text-gray-600 text-[10px] font-bold uppercase leading-relaxed">Calcul automatique des parts de chaque membre en temps réel.</p>
            </div>
            
            <div class="p-8 bg-[#0f0f0f] border border-white/10 rounded-[2rem] text-left">
                
                <h3 class="text-white font-black uppercase italic text-sm mb-2">Système de Rating</h3>
                <p class="text-gray-600 text-[10px] font-bold uppercase leading-relaxed">Améliorez votre score de fiabilité pour accéder à de meilleurs logements.</p>
            </div>

            <div class="p-8 bg-[#0f0f0f] border border-white/10 rounded-[2rem] text-left">
                
                <h3 class="text-white font-black uppercase italic text-sm mb-2">Galerie Privée</h3>
                <p class="text-gray-600 text-[10px] font-bold uppercase leading-relaxed">Gardez vos souvenirs et vos documents importants au même endroit.</p>
            </div>
        </div>
    </main>

    <footer class="mt-20 py-10 border-t border-white/5 text-center">
        <p class="text-[9px] font-black text-gray-700 uppercase tracking-[0.5em]">SpaceColoc Architecture © 2026</p>
    </footer>

</body>
</html>