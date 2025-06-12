<div class="bg-gray-50 min-h-screen" x-data="dashboard()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('components.ui.toast')

        <!-- Filter Controls -->
        <!-- <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select x-model="selectedDateRange" @change="updateStats()" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="7">Last 7 days</option>
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 90 days</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select x-model="selectedStatus" @change="filterData()" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input
                            x-model="searchQuery"
                            @input="filterData()"
                            type="text"
                            placeholder="Search users, orders..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 pl-10 text-sm">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <button @click="refreshData()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div> -->
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer" @click="openModal('users')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Users</h3>
                        <p class="text-3xl font-bold text-blue-600" x-text="stats.users.toLocaleString()"></p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="text-green-600" x-text="stats.usersGrowth"></span> from last period
                        </p>
                    </div>
                    <div class="text-blue-600">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer" @click="openModal('revenue')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Revenue</h3>
                        <p class="text-3xl font-bold text-green-600" x-text="'$' + stats.revenue.toLocaleString()"></p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="text-green-600" x-text="stats.revenueGrowth"></span> from last period
                        </p>
                    </div>
                    <div class="text-green-600">
                        <i class="fas fa-dollar-sign text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer" @click="openModal('orders')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Orders</h3>
                        <p class="text-3xl font-bold text-purple-600" x-text="stats.orders.toLocaleString()"></p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="text-green-600" x-text="stats.ordersGrowth"></span> from last period
                        </p>
                    </div>
                    <div class="text-purple-600">
                        <i class="fas fa-shopping-cart text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer" @click="openModal('conversion')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Conversion Rate</h3>
                        <p class="text-3xl font-bold text-orange-600" x-text="stats.conversionRate + '%'"></p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="text-green-600" x-text="stats.conversionGrowth"></span> from last period
                        </p>
                    </div>
                    <div class="text-orange-600">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Revenue Trend</h3>
                <canvas id="revenueChart" class="max-h-64"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">User Growth</h3>
                <canvas id="userChart" class="max-h-64"></canvas>
            </div>
        </div>

        <!-- Powergrid Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">User Data</h3>
            </div>

            <!-- Table View Section -->
            <div x-show="currentView === 'table'" class="w-full overflow-x-auto">
                <div class="min-w-full px-4 sm:px-6 lg:px-8 py-4">
                    <!-- User Table Livewire Component -->
                    <livewire:user-table />

                    <!-- Edit User Modal Component -->
                    <livewire:user.edit-user />
                </div>
            </div>
        </div>


    </div>
    <!-- Modal -->
    <div x-show="showModal" x-cloak x-transition class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-opacity-50 transition-opacity" @click="closeModal()"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="modalTitle"></h3>
                    <div x-html="modalContent"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function dashboard() {
            return {
                // State
                selectedDateRange: '30',
                selectedStatus: '',
                searchQuery: '',
                currentView: 'table',
                currentPage: 1,
                itemsPerPage: 5,
                sortField: 'name',
                sortDirection: 'asc',
                showModal: false,
                modalTitle: '',
                modalContent: '',

                // paginateData: '',
                // Data
                stats: {
                    users: 1234,
                    usersGrowth: '+12%',
                    revenue: 45678,
                    revenueGrowth: '+8%',
                    orders: 892,
                    ordersGrowth: '+15%',
                    conversionRate: 3.2,
                    conversionGrowth: '+0.5%'
                },

                // Methods
                init() {
                    this.initCharts();
                    this.updateStats();
                },

                initCharts() {
                    // Revenue Chart
                    setTimeout(() => {
                        const revenueCtx = document.getElementById('revenueChart');
                        if (revenueCtx) {
                            new Chart(revenueCtx, {
                                type: 'line',
                                data: {
                                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                                    datasets: [{
                                        label: 'Revenue',
                                        data: [12000, 19000, 15000, 25000, 32000, 45000],
                                        borderColor: 'rgb(34, 197, 94)',
                                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                        tension: 0.4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        }

                        // User Chart
                        const userCtx = document.getElementById('userChart');
                        if (userCtx) {
                            new Chart(userCtx, {
                                type: 'bar',
                                data: {
                                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                                    datasets: [{
                                        label: 'Users',
                                        data: [120, 190, 150, 250, 320, 450],
                                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                                        borderColor: 'rgb(59, 130, 246)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        }
                    }, 100);
                },

                updateStats() {
                    // Simulate API call to update stats based on date range
                    console.log('Updating stats for', this.selectedDateRange, 'days');
                },

                filterData() {
                    this.currentPage = 1; // Reset to first page when filtering
                },


                openModal(type) {
                    this.showModal = true;
                    switch (type) {
                        case 'users':
                            this.modalTitle = 'User Details';
                            this.modalContent = '<p>Detailed user analytics and breakdown...</p>';
                            break;
                        case 'revenue':
                            this.modalTitle = 'Revenue Breakdown';
                            this.modalContent = '<p>Detailed revenue analytics...</p>';
                            break;
                        case 'orders':
                            this.modalTitle = 'Order Analytics';
                            this.modalContent = '<p>Detailed order analytics...</p>';
                            break;
                        case 'conversion':
                            this.modalTitle = 'Conversion Analytics';
                            this.modalContent = '<p>Detailed conversion rate analytics...</p>';
                            break;
                    }
                },

                closeModal() {
                    this.showModal = false;
                },

                editItem(item) {
                    console.log('Editing item:', item);
                    // In Laravel/Livewire: $wire.editItem(item.id);
                },

                deleteItem(id) {
                    if (confirm('Are you sure you want to delete this item?')) {
                        this.data = this.data.filter(item => item.id !== id);
                        console.log('Deleted item:', id);
                        // In Laravel/Livewire: $wire.deleteItem(id);
                    }
                },

            }
        }
    </script>
</div>