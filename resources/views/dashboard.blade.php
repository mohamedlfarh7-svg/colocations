<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Space</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-color: #050505;
            background-image: radial-gradient(circle at 50% -20%, #1e1e1e, #050505);
        }
    </style>
</head>
<body class="text-gray-200 flex items-center justify-center min-h-screen font-sans">

    <div class="max-w-md w-full mx-4">
        
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-linear-to-r from-blue-500 to-purple-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            
            <div class="relative bg-[#0f0f0f] border border-white/10 p-8 rounded-2xl shadow-2xl backdrop-blur-xl">
                
                <div class="w-16 h-16 bg-linear-to-tr from-blue-500/20 to-purple-500/20 border border-white/10 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <h1 class="text-2xl font-semibold bg-linear-to-r from-white to-gray-400 bg-clip-text text-transparent mb-2">
                    Welcome back!
                </h1>
                <p class="text-gray-500 text-sm mb-8">
                    {{ Auth::user()->name ?? 'Guest User' }} • <span class="text-blue-500/80">Active</span>
                </p>

                <div class="flex justify-center gap-3 mb-8">
                    <div class="px-3 py-1 bg-white/5 border border-white/5 rounded-full text-[10px] uppercase tracking-wider text-gray-400">
                        Admin Mode
                    </div>
                    <div class="px-3 py-1 bg-white/5 border border-white/5 rounded-full text-[10px] uppercase tracking-wider text-gray-400">
                        v2.1.0
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('colocations.index') }}" class="block w-full py-3 px-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm transition-all duration-200">
                        View Colocations
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 bg-linear-to-r from-red-500/10 to-red-600/10 hover:from-red-500 hover:to-red-600 border border-red-500/20 hover:border-red-500 text-red-500 hover:text-white rounded-xl text-sm font-medium transition-all duration-300 cursor-pointer shadow-lg shadow-red-500/5">
                            Logout System
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <p class="text-center mt-8 text-gray-600 text-xs tracking-widest uppercase">
            &copy; 2026 Colocation App
        </p>
    </div>

</body>
</html>