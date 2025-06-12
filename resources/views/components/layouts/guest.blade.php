<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>


<body class="bg-gray-100">

    <!-- Page Content -->
    <div>
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>

</html>