<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class UserTable extends PowerGridComponent
{
    public string $tableName = 'user-table';

    public array $companies = [];

    public string $companyFilter = '';
    public string $isActiveFilter = '';
    public string $searchFilter = '';

    // Add these properties to make filters reactive
    protected $listeners = [
        'delete',
        'userUpdated' => 'refreshTable'
    ];

    // Make the filters updatable
    public function updatedCompanyFilter()
    {
        $this->resetPage();
    }

    public function updatedIsActiveFilter()
    {
        $this->resetPage();
    }

    public function updatedSearchFilter()
    {
        $this->resetPage();
    }

    public function setUp(): array
    {

        $this->companies = User::query()
            ->select('company')
            ->distinct()
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->pluck('company')
            ->toArray();

        return [
            PowerGrid::header()
                ->includeViewOnTop('livewire.filters.user-filters', [
                    'companies' => $this->companies,
                    'companyFilter' => $this->companyFilter,
                    'isActiveFilter' => $this->isActiveFilter,
                    'searchFilter' => $this->searchFilter,
                ]),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $currentUserId = Auth::id();

        $query = User::query()
            ->where('id', '!=', $currentUserId)
            ->whereNull('deleted_at');

        // Apply company filter
        if (!empty($this->companyFilter)) {
            $query->where('company', $this->companyFilter);
        }

        // Apply active status filter
        if ($this->isActiveFilter !== '') {
            $query->where('is_active', (bool) $this->isActiveFilter);
        }

        // Apply search filter
        if (!empty($this->searchFilter)) {
            $searchTerm = trim($this->searchFilter);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                    ->orWhere('company', 'like', "%{$searchTerm}%")
                    ->orWhere('address', 'like', "%{$searchTerm}%");
            });
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [];
    }


    public function fields(): PowerGridFields
    {

        return PowerGrid::fields()
            ->add('name')
            ->add('email')
            ->add('company')
            ->add('address')
            ->add('phone_number')
            ->add('is_active')
            ->add('sr_no', function () {
                static $counter = 0;
                $currentPage = request('page', 1);
                $perPage = $this->perPage ?? 10;
                return ++$counter + (($currentPage - 1) * $perPage);
            });
    }

    public function columns(): array
    {
        return [

            Column::make('Sr No', 'sr_no')
                ->sortable(false),
            Column::make('Name', 'name')
                ->sortable(),

            Column::make('Email', 'email')
                ->sortable(),

            Column::make('Company', 'company')
                ->sortable(),

            Column::make('Address', 'address')
                ->sortable(),

            Column::make('Phone number', 'phone_number')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        // Keep this empty since we're using custom filters
        return [];
    }

    public function delete($rowId): void
    {
        try {
            //code...
            if (Auth::id() == $rowId) {
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'You cannot delete your own account.',
                ]);
                return;
            }

            $user = User::find($rowId);

            if ($user) {
                $user->delete();
                $this->dispatch('$refresh');
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => 'User deleted successfully!',
                ]);
            } else {
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'User not found.',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actions(User $row): array
    {
        $currentUserId = Auth::id();
        $buttons = [];

        // Edit Button
        $buttons[] = Button::add('edit')
            ->slot('&#9889; Edit')
            ->id()
            ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
            ->dispatch('show-user-edit-modal', ['userId' => $row->id]);

        // Delete Button - only if user is not the currently logged-in user
        if ($row->id !== $currentUserId) {
            $buttons[] = Button::add('delete-user')
                ->slot('🗑️ Delete')
                ->id()
                ->class('pg-btn-white text-red-600 dark:text-red-400 dark:border-red-500 dark:ring-red-500 dark:hover:bg-red-700 dark:bg-red-600 hover:bg-red-100 border border-red-400')
                ->attributes([
                    'onclick' => "if(confirm('Are you sure you want to delete this user?')) Livewire.dispatch('delete', { rowId: {$row->id} })"
                ]);
        }

        return $buttons;
    }

    #[\Livewire\Attributes\On('userUpdated')]
    public function refreshTable(): void
    {
        $this->dispatch('$refresh');
    }
}
