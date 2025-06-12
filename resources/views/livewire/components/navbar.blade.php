<!-- Header -->
<div class="bg-white shadow-sm  px-6 py-4 flex items-center justify-between">
    <!-- Left: Welcome Message -->
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Welcome back, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-gray-500">Glad to see you again!</p>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-4" x-data="notification()">
        <!-- Notifications -->
        <div x-data="{ showNotifications: false }" class="relative">
            <button @click="showNotifications = !showNotifications"
                class="relative p-2 rounded-full hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405C18.21 14.79 18 14.398 18 14V11a6 6 0 00-5-5.917V5a1 1 0 10-2 0v.083A6 6 0 006 11v3c0 .398-.21.79-.595 1.095L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                    x-show="notifications.length" x-text="notifications.length"></span>
            </button>
            <div x-show="showNotifications" x-cloak x-transition class="fixed inset-0 z-40 overflow-hidden">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-opacity-50" @click="showNotifications = false"></div>

                <!-- Modal Panel -->
                <div class="absolute right-0 top-0 h-full w-96 bg-white shadow-xl flex flex-col">
                    <!-- Header -->
                    <div class="p-6 flex items-center justify-between border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                        <button @click="showNotifications = false" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 overflow-y-auto space-y-3 flex-1">
                        <template x-for="notification in notifications" :key="notification.id">
                            <div class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                                <p class="text-sm font-medium" x-text="notification.title"></p>
                                <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                <button @click="removeNotification(notification.id)"
                                    class="text-xs text-blue-600 mt-2 hover:text-blue-800">
                                    Dismiss
                                </button>
                            </div>
                        </template>

                        <template x-if="notifications.length === 0">
                            <div class="text-sm text-center text-gray-500">No notifications found.</div>
                        </template>
                    </div>
                </div>
            </div>

        </div>

        <!-- User Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2">
                <div
                    class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full font-semibold uppercase">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <svg :class="{ 'rotate-180': open }"
                    class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <div class="p-3 border-b text-sm text-gray-700">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <button wire:click="logout"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS logic -->
<script>
    function notification() {
        return {
            notifications: [{
                    id: 1,
                    title: 'New Order',
                    message: 'Order #1234 has been placed',
                    time: '2 min ago'
                },
                {
                    id: 2,
                    title: 'System Update',
                    message: 'System will be updated tonight',
                    time: '1 hour ago'
                },
                {
                    id: 3,
                    title: 'Payment Received',
                    message: 'Payment of $500 received',
                    time: '2 hours ago'
                }
            ],
            removeNotification(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }
        }
    }
</script>