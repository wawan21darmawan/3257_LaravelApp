<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-xl border border-slate-100">
            
            <!-- Header -->
            <div class="text-center">
                <h2 class="mt-4 text-3xl font-black text-slate-900">
                    Selamat Datang
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Masuk cepat untuk mulai memesan tiket event impianmu.
                </p>
            </div>

            <!-- ================= FORM LOGIN MANUAL ================= -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" 
                        placeholder="nama@email.com">
                    <!-- Menampilkan pesan error jika email salah -->
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required 
                        class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" 
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm mt-2">
                    Masuk
                </button>
            </form>

            <!-- ================= PEMBATAS VISUAL ================= -->
            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="px-4 text-sm text-slate-400 font-medium">atau masuk dengan</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <!-- Tombol SSO Google -->
            <div class="mt-8">
                <a href="{{ url('/auth/google') }}" class="w-full flex items-center justify-center gap-3 px-8 py-4 border border-slate-200 rounded-2xl shadow-sm text-base font-bold text-slate-700 bg-white hover:bg-slate-50 hover:shadow-md transition-all duration-200">
                    <!-- Logo Google SVG -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </div>
    </div>

</body>
</html>