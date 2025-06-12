<div>
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-50">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Edit User</h2>

            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block mb-1">Name</label>
                    <input type="text" wire:model.defer="name" class="w-full border border-gray-300 rounded p-2">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Email</label>
                    <input type="email" wire:model.defer="email" class="w-full border border-gray-300 rounded p-2">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Company</label>
                    <input type="text" wire:model.defer="company" class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Address</label>
                    <input type="text" wire:model.defer="address" class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Phone</label>
                    <input type="text" wire:model.defer="phone_number" class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="text-right">
                    <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>