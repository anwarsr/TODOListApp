<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Microsoft Todo Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <style>
        /* Background soft gradient ala HealthyTogether */
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
                        <i class="fa-solid fa-list-check text-4xl text-indigo-600"></i>
                    </div>
                </div>
                <h2
                    class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 tracking-wide">
                    GenZtask
                </h2>
                <h3 class="text-2xl font-semibold text-gray-800 mt-2 animate-fade-in-up">
                    Welcome Back
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    Sign in to manage your tasks
                </p>
            </div>


            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
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
                        <input id="password" name="password" type="password" required autocomplete="current-password"
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
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Sign In
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-indigo-500 hover:underline font-medium">
                        Create one
                    </a>
                </p>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="text-sm text-indigo-600 hover:underline">Login as admin</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
