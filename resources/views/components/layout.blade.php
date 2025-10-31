<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About page for this Laravel application.">
    <meta name="author" content="gohomewho">
    <title>{{ $title ?? 'Laravel Application' }}</title>
    <link rel="icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="bg-gray-100 dark:bg-gray-800 p-4 shadow-sm">
        <div class="flex gap-6">
            <x-nav-link href="/" overwrite="true" class="text-5xl text-white">Home</x-nav-link>
            <x-nav-link href="/about">About</x-nav-link>
            <x-nav-link href="/contact">Contact</x-nav-link>
        </div>
    </nav>
    <main>
        {{ $slot }}
    </main>
</body>
</html>