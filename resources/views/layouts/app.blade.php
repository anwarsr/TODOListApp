<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenZTask</title>
    <!-- Inline SVG favicon for GenZTask (task-style icon) -->
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

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: scale(1.05);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.05);
        }

        .task-item {
            transition: all 0.3s ease;
        }

        .task-item:hover {
            transform: translateX(5px);
        }

    </style>
</head>

<body class="bg-gray-50">
    @auth
    <nav class="glass-nav sticky top-0 z-50 animate-fade-in-up">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center animate-pulse-slow">
                        <i class="fa-solid fa-list-check text-xl text-indigo-500"></i>
                    </div>
                    <h1 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500">GenZtask</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-gradient px-4 py-2 rounded-lg text-white text-sm font-medium transition-all">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @if(session('success'))
    <div class="fixed bottom-4 right-4 glass-card px-6 py-3 text-green-700 font-medium animate-fade-in-up">
        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 right-4 glass-card px-6 py-3 text-red-600 font-medium animate-fade-in-up">
        <i class="fa-solid fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
    @endif

    <script>
        // Auto-hide messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.fixed.bottom-4');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>