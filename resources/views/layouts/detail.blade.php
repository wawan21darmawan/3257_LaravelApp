<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - AmikomEventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- NAVBAR KHUSUS DETAIL -->
    <nav
        class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center bg-white border-b sticky top-8 z-40 rounded-b-2xl shadow-sm">
        <a href="index.html" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                AH</div>
            <span class="text-xl font-bold tracking-tight">AmikomEventHub</span>
        </a>
        <div class="flex gap-4">
            <button class="px-4 py-2 text-slate-600 font-medium">Cari Event</button>
            <button class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- KONTEN -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-20 text-center">
        © 2024 AmikomEventHub
    </footer>

</body>

</html>