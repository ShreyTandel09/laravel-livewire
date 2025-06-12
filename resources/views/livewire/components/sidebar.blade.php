<div class="flex h-screen overflow-hidden">

    <!-- Sidebar (fixed on the left) -->
    <aside class="w-64 bg-white shadow-md  fixed top-0 left-0 h-screen z-40">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-blue-600">Auth App</h1>
        </div>
        <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-80px)]">
            <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-blue-50 text-gray-700 font-medium">Dashboard</a>
            <a href="{{ route('profile') }}" class="block p-2 rounded hover:bg-blue-50 text-gray-700 font-medium"> Profile</a>
            <a href="#" class="block p-2 rounded hover:bg-blue-50 text-gray-700 font-medium"> Settings</a>
        </nav>
    </aside>

    <!-- Main content (pushed right due to sidebar) -->
    <div class="flex-1 ml-64 flex flex-col overflow-hidden">

        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Dashboard</h2>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">{{ auth()->user()->email }}</span>
                <button wire:click="logout" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Logout</button>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
            <div class="bg-white p-6 rounded shadow-sm">
                <h3 class="text-lg font-bold mb-4">Welcome, {{ auth()->user()->name }} 👋</h3>
                <p class="text-gray-600">This is your main dashboard content.</p>
                <!-- Tall content to test scrolling -->
                <div class="mt-6 h-[1200px] bg-gray-200 rounded"></div>
            </div>
        </main>

    </div>
</div>