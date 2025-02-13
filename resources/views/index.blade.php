<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayAhead - To-Do App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white overflow-hidden">
    <nav class="bg-gray-100 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                <span class="ml-2 text-2xl font-semibold text-gray-900">StayAhead</span>
            </a>

            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}" class="text-gray-900 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="text-gray-900 hover:text-blue-500">Register</a>
            </div>

            <div class="md:hidden flex items-center">
                <button id="hamburger-menu" class="text-gray-900 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden hidden bg-gray-100 p-4">
            <a href="{{ route('login') }}" class="block text-gray-900 py-2">Login</a>
            <a href="{{ route('register') }}" class="block text-gray-900 py-2">Register</a>
        </div>
    </nav>

    <div class="flex justify-center items-center min-h-screen">
        <div class="text-center mb-20 pb-52">
            <h1 class="text-4xl font-bold text-gray-600 mb-6">Welcome to StayAhead!</h1>
            <p class="text-lg text-gray-700 mb-4">Your to-do list app to stay organized and productive.</p>
            <p class="text-gray-600">Please log in or register to start using the app.</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburgerMenu = document.getElementById('hamburger-menu');
            const mobileMenu = document.getElementById('mobile-menu');

            if (hamburgerMenu) {
                hamburgerMenu.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
