<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenZTask</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect rx='18' width='100' height='100' fill='%230ea5e9'/><path d='M28 52 L42 66 L74 34' stroke='%23fff' stroke-width='7' fill='none' stroke-linecap='round' stroke-linejoin='round'/></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <style>
        :root {
            --sky: #e0f2fe;
            --navy: #0f172a;
            --indigo: #6366f1;
            --purple: #8b5cf6;
            --slate: #1e293b;
        }

        body {
            min-height: 100vh;
            font-family: 'Manrope', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(140deg, #0ea5e9 0%, #a5b4fc 35%, #f8fafc 70%);
            color: var(--navy);
        }

        .app-nav {
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.65);
            border-bottom: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.15);
        }

        .app-shell {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 32px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .sidebar-panel {
            background: rgba(255, 255, 255, 0.86);
            border-radius: 22px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(18px);
        }

        .main-panel {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 26px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(18px);
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            transition: all 0.2s ease;
            color: #0f172a;
        }

        .category-item:hover {
            background: rgba(99, 102, 241, 0.08);
        }

        .category-item.is-active {
            background: linear-gradient(120deg, rgba(99, 102, 241, 0.15), rgba(14, 165, 233, 0.15));
            border: 1px solid rgba(99, 102, 241, 0.25);
        }

        .task-card {
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            padding: 18px 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12);
        }

        .pill {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .primary-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.35);
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }

        .primary-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.4);
        }

        .ghost-btn {
            background: rgba(99, 102, 241, 0.12);
            color: #4338ca;
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 700;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 12px;
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
    @auth
    <nav class="app-nav">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-check-double text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">GenZtask</p>
                        <p class="text-lg font-bold text-slate-900">Focus on what matters</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <main class="px-4 md:px-6 py-6">
        @yield('content')
    </main>

    @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-white/90 border border-green-200 shadow-xl px-5 py-3 rounded-xl text-green-700 font-semibold animate-fade-in-up">
        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 right-4 bg-white/90 border border-red-200 shadow-xl px-5 py-3 rounded-xl text-red-600 font-semibold animate-fade-in-up">
        <i class="fa-solid fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.fixed.bottom-4');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 320);
                }, 5000);
            });
        });
    </script>
    @include('partials.delete_modal')
</body>
</html>