<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayAhead - To-Do App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white overflow-hidden">

    <!-- Navbar -->
    <nav class="bg-gray-100 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-gray-900 text-xl font-semibold">StayAhead</a>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-gray-900">Login</a>
                <a href="{{ route('register') }}" class="text-gray-900">Register</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex justify-center items-center min-h-screen">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-600 mb-6">Welcome to StayAhead!</h1>
            <p class="text-lg text-gray-700 mb-4">Your to-do list app to stay organized and productive.</p>
            <p class="text-gray-600">Please log in or register to start using the app.</p>
        </div>
    </div>

</body>

</html>
