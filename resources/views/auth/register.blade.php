<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte | SpaceColoc</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 font-sans text-gray-200">
    <div class="relative w-full max-w-md group">
        <div class="absolute -inset-1 bg-linear-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
        
        <div class="relative bg-[#0f0f0f] border border-white/10 rounded-3xl shadow-2xl p-10 backdrop-blur-xl">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600/10 rounded-2xl border border-blue-500/20 mb-4">
                    <span class="text-2xl font-black text-blue-500 italic uppercase">S</span>
                </div>
                <h1 class="text-3xl font-black text-white italic tracking-tighter uppercase">Rejoindre l'espace</h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-2">Commencez l'aventure ColocShare</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Nom Complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all">
                    @error('name') <p class="text-red-500 text-[9px] mt-1 ml-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all">
                    @error('email') <p class="text-red-500 text-[9px] mt-1 ml-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Mot de passe</label>
                        <input type="password" name="password" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Confirmation</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 text-[10px] uppercase tracking-[0.2em] mt-4 cursor-pointer">
                    Créer mon compte
                </button>

                <div class="text-center pt-6">
                    <p class="text-[9px] font-black text-gray-600 uppercase tracking-widest">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400 transition-colors ml-1">Se connecter</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>