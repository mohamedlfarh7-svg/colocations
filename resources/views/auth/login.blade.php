<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SpaceColoc</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="relative w-full max-w-md group">
        <div class="absolute -inset-1 bg-linear-to-r from-blue-600 to-purple-600 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
        
        <div class="relative bg-[#0f0f0f] border border-white/10 rounded-3xl shadow-2xl p-10 backdrop-blur-xl">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600/10 rounded-2xl border border-blue-500/20 mb-4">
                    <span class="text-2xl font-black text-blue-500 italic uppercase">S</span>
                </div>
                <h1 class="text-3xl font-black text-white italic tracking-tighter uppercase">Content de vous revoir</h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-2">Connectez-vous à votre espace actif</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-400 text-[10px] font-black uppercase tracking-widest">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all placeholder-gray-800">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em]">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[8px] font-black text-blue-500/60 hover:text-blue-400 uppercase tracking-widest transition-colors">Oublié ?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 transition-all">
                </div>

                <div class="flex items-center ml-1">
                    <input type="checkbox" name="remember" id="remember" 
                        class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-500 focus:ring-offset-[#0f0f0f]">
                    <label for="remember" class="ml-2 text-[9px] font-black text-gray-500 uppercase tracking-widest">Se souvenir de moi</label>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 text-[10px] uppercase tracking-[0.2em] cursor-pointer">
                    Se Connecter
                </button>

                <div class="text-center pt-6">
                    <p class="text-[9px] font-black text-gray-600 uppercase tracking-widest">
                        Pas encore membre ? 
                        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400 transition-colors ml-1">Créer un compte</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>