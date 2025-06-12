<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-end">

    {{-- Company Filter --}}
    <div>
        <label for="filterCompany" class="block text-sm font-medium text-gray-700">Filter by Company</label>
        <select wire:model.live="companyFilter" id="filterCompany"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Companies</option>
            @foreach ($companies as $company)
            <option value="{{ $company }}">{{ $company }}</option>
            @endforeach
        </select>
    </div>

    {{-- Active Status Filter --}}
    <div>
        <label for="filterIsActive" class="block text-sm font-medium text-gray-700">Filter by Active Status</label>
        <select wire:model.live="isActiveFilter" id="filterIsActive"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    {{-- Search Input --}}
    <div>
        <label for="searchFilter" class="block text-sm font-medium text-gray-700">Search</label>
        <input type="text"
            wire:model.live.debounce.300ms="searchFilter"
            id="searchFilter"
            placeholder="Search name, email, phone, company..."
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
    </div>

</div>