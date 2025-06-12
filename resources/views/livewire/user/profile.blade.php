<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md border border-gray-200"
    x-data="{
        name: '{{ addslashes(auth()->user()->name) }}',
        phone_number: '{{ addslashes(auth()->user()->phone_number) }}',
        company: '{{ addslashes(auth()->user()->company) }}',
        address: `{{ addslashes(auth()->user()->address) }}`,
        submitForm() {
            $wire.call('updateProfile', {
                name: this.name,
                phone_number: this.phone_number,
                company: this.company,
                address: this.address
            });
        }
    }">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Edit Profile</h2>

    <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
            <input x-model="name" type="text"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
            <input x-model="phone_number" type="text"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Company</label>
            <input x-model="company" type="text"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" value="{{ auth()->user()->email }}" readonly
                class="w-full border border-gray-200 bg-gray-100 rounded-md px-4 py-2 text-sm cursor-not-allowed" />
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
            <textarea x-model="address" rows="3"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
        </div>

        <div class="md:col-span-2 text-right">
            <button type="submit"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-md transition">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>