<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenZTask — Register</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
        <rect rx='18' width='100' height='100' fill='%23667eea'/>
        <rect x='22' y='24' width='56' height='8' rx='3' fill='%23ffffff' opacity='0.15'/>
        <rect x='22' y='40' width='36' height='8' rx='3' fill='%23ffffff' opacity='0.15'/>
        <rect x='22' y='56' width='56' height='8' rx='3' fill='%23ffffff' opacity='0.15'/>
        <path d='M30 58 L44 72 L74 38' stroke='%23fff' stroke-width='6' fill='none' stroke-linecap='round' stroke-linejoin='round'/>
    </svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <style>
        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background: radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.18), transparent 32%),
                        radial-gradient(circle at 80% 0%, rgba(14, 165, 233, 0.16), transparent 34%),
                        linear-gradient(140deg, #0ea5e9 0%, #a5b4fc 38%, #f8fafc 75%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(18px);
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 34px 90px rgba(15, 23, 42, 0.2);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.2s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(99, 102, 241, 0.35);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 14px;
            padding: 12px 14px;
            width: 100%;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center px-6 py-12">
        <div class="max-w-6xl w-full mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 glass-card p-10 lg:p-12 animate-fade-in-up">
            <!-- Hero Copy -->
            <div class="space-y-6 flex flex-col justify-center">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-400 via-purple-400 to-sky-400 shadow-lg flex items-center justify-center">
                        <div class="bg-white w-10 h-10 rounded-xl flex items-center justify-center shadow-inner">
                            <i class="fa-solid fa-user-plus text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-700">GenZtask</p>
                        <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 via-purple-600 to-sky-500">
                            Create Your Space
                        </h2>
                    </div>
                </div>
                <p class="text-lg text-slate-700 leading-relaxed max-w-xl">
                    Set up your account to start organizing tasks with categories, subtasks, and reminders—synced across devices.
                </p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3 top-4 text-gray-400"></i>
                        <input id="name" name="name" type="text" required autocomplete="name"
                            class="input-field pl-10 pr-3" placeholder="Your full name">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3 top-4 text-gray-400"></i>
                        <input id="email" name="email" type="email" required autocomplete="email"
                            class="input-field pl-10 pr-3" placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-4 text-gray-400"></i>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="input-field pl-10 pr-3" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-4 text-gray-400"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                            class="input-field pl-10 pr-3" placeholder="••••••••">
                    </div>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm animate-shake">
                    {{ $errors->first() }}
                </div>
                @endif

                <button type="submit"
                    class="w-full py-3 text-white font-semibold rounded-xl btn-gradient shadow-md">
                    <i class="fa-solid fa-user-plus mr-2"></i> Create Account
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-500 hover:underline font-medium">
                        Sign in
                    </a>
                </p>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white/90 text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Google Sign Up Button -->
                <a href="{{ route('auth.google') }}" 
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-200 rounded-xl hover:bg-white transition-all duration-200 hover:shadow-md group">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-gray-700 font-medium group-hover:text-gray-900">Sign up with Google</span>
                </a>
            </form>
        </div>
    </div>
</body>
</html>
