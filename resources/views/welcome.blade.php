<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TodoApp</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-image: url('https://source.unsplash.com/1600x900/?technology,work');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.7);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .content {
            z-index: 2;
            position: relative;
            text-align: center;
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: fadeInDown 2s ease-in-out;
        }

        p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            animation: fadeInUp 2s ease-in-out;
        }

        .btn {
            display: inline-block;
            padding: 0.65rem 1.3rem;
            margin: 1.3rem;
            font-size: 1.125rem;
            font-weight: 600;
            text-transform: uppercase;
            color: white;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.0);
            background: linear-gradient(90deg, #ff4b2b, #ff416c);
        }

        .icon img {
            width: 100px;
            animation: bounce 2s infinite;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="min-h-screen flex flex-col items-center justify-center content">
        <header class="mb-8">
            <h1>TodoApp</h1>
            <p>Organiza tus tareas de manera eficiente</p>
        </header>

        <main class="flex space-x-4">
            <a href="{{ route('login') }}" class="btn">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="btn">
                Registrarse
            </a>
        </main>

        <div class="mt-12 flex flex-col items-center icon">
            <img src="https://img.icons8.com/ios-filled/100/ffffff/task.png" alt="Tareas">
            <p class="mt-4 text-lg">Gestión de tareas rápida y sencilla</p>
        </div>
    </div>
</body>
</html>
