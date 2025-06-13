<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
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
    // public string $sortField = '';
    // public string $sortDirection = 'asc';
    public bool $persistSort = true;
    protected $listeners = [
        'delete',
        'userUpdated' => 'refreshTable'
    ];


    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }
    public function setUp(): array
    {
        $this->persist(['filters', 'sorting'], prefix: (string) Auth::id());

        // $this->persist(['sorting']);
        return [
            PowerGrid::header(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()
            ->where('id', '!=', Auth::id())
            ->whereNull('deleted_at');
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
            ->add('is_active', fn($user) => $user->is_active
                ? '<span class="text-green-600 font-semibold">✔ Active</span>'
                : '<span class="text-red-600 font-semibold">✖ Inactive</span>')->add('sr_no', function () {
                static $counter = 0;
                $currentPage = request('page', 1);
                $perPage = $this->perPage ?? 10;
                return ++$counter + (($currentPage - 1) * $perPage);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Sr No', 'sr_no'),
            Column::make('Name', 'name')->sortable($this->setUp())->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Company', 'company')->sortable()->searchable(),
            Column::make('Address', 'address')->sortable()->searchable(),
            Column::make('Phone number', 'phone_number')->sortable()->searchable(),
            Column::make('Status', 'is_active'),
            Column::action('Action'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('company', 'company')
                ->dataSource(
                    User::query()
                        ->select('company')
                        ->whereNotNull('company')
                        ->where('company', '!=', '')
                        ->distinct()
                        ->get()
                )
                ->optionLabel('company')
                ->optionValue('company'),
            Filter::boolean('is_active', 'is_active')
                ->label('Active', 'Inactive'),
        ];
    }

    public function actions(User $row): array
    {
        $buttons = [];

        $buttons[] = Button::add('edit')
            ->slot('✏️ Edit')
            ->id()
            ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
            ->dispatch('show-user-edit-modal', ['userId' => $row->id]);

        if ($row->id !== Auth::id()) {
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

    public function delete($rowId): void
    {
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
    }

    #[\Livewire\Attributes\On('userUpdated')]
    public function refreshTable(): void
    {
        $this->dispatch('$refresh');
    }
}
