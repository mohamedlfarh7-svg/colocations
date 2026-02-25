<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style>
            :root {
                --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            }
            body { font-family: var(--font-sans); }
        </style>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="w-full max-w-[400px]">
            <div class="bg-white dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-8 text-center">
                
                <h1 class="text-xl font-medium mb-2 dark:text-white">Marhba bik!</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm mb-8">Ekhtar ach bghiti ddir daba:</p>

                <div class="flex flex-col gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium transition-opacity hover:opacity-90">
                                Go to Dashboard
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-2 border border-[#19140035] dark:border-[#3E3E3A] dark:text-[#EDEDEC] rounded-sm text-sm font-medium hover:bg-gray-50 dark:hover:bg-[#1e1e1d] cursor-pointer">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="w-full py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium transition-opacity hover:opacity-90">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full py-2 border border-[#19140035] dark:border-[#3E3E3A] dark:text-[#EDEDEC] rounded-sm text-sm font-medium hover:bg-gray-50 dark:hover:bg-[#1e1e1d]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <footer class="mt-6 text-center text-[12px] text-[#706f6c] dark:text-[#A1A09A]">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>

    </body>
</html>