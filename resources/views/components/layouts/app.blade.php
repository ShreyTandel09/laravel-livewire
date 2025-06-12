<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laravel Auth App' }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<script>
    window.addEventListener('livewire:load', function() {
        toastr.options = {
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        }
    });
</script>

<body class="bg-gray-100">
    <div class="flex h-screen">


        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            @livewire('components.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow-sm border-b">
                @livewire('components.navbar')
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>



</html>