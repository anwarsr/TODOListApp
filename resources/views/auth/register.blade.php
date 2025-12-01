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
            background: linear-gradient(120deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: #2d3748;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: scale(1.05);
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
        }

        .bg-shape.one {
            width: 300px;
            height: 300px;
            background: #a78bfa;
            top: 10%;
            left: 15%;
        }

        .bg-shape.two {
            width: 400px;
            height: 400px;
            background: #63b3ed;
            bottom: 10%;
            right: 10%;
        }
    </style>
</head>
<body>
    <div class="relative flex items-center justify-center min-h-screen overflow-hidden">
        <div class="bg-shape one animate-float"></div>
        <div class="bg-shape two animate-float" style="animation-delay: 1.5s;"></div>

        <div class="max-w-md w-full px-8 py-10 glass-card animate-fade-in-up">
           <!-- Logo -->
            <div class="text-center mb-10">
                <div class="text-center animate-fade-in-up">
                <div
                    class="mx-auto w-24 h-24 bg-gradient-to-tr from-indigo-400 via-purple-400 to-pink-400 rounded-3xl shadow-lg flex items-center justify-center mb-4 animate-fade-in">
                    <div class="bg-white w-20 h-20 rounded-2xl flex items-center justify-center shadow-inner animate-pulse-slow">
                        <i class="fa-solid fa-user-plus text-4xl text-indigo-600"></i>
                    </div>
                </div>
                <h2
                    class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 tracking-wide">
                    GenZtask
                </h2>
                <h3 class="text-2xl font-semibold text-gray-800 mt-2 animate-fade-in-up">
                    Create an Account
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    Join and start managing your tasks
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
                               class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all"
                               placeholder="Your full name">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3 top-4 text-gray-400"></i>
                        <input id="email" name="email" type="email" required autocomplete="email"
                               class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all"
                               placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-4 text-gray-400"></i>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all"
                               placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-4 text-gray-400"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all"
                               placeholder="••••••••">
                    </div>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm animate-shake">
                    {{ $errors->first() }}
                </div>
                @endif

                <button type="submit"
                        class="w-full py-3 text-white font-medium rounded-lg btn-gradient focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
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
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Google Sign Up Button -->
                <a href="{{ route('auth.google') }}" 
                   class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 hover:shadow-md group">
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
