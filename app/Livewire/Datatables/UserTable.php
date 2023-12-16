<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{User};
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class UserTable extends DataTableComponent
{


    public $tipe;
    public string $tableName = 'users';




    public function builder(): Builder
    {
        if ($this->tipe === 'superadmin') {
            return User::query()->where('role_user', $this->tipe);
        } else {
            return User::query()->where('tipe_user', $this->tipe)->whereNot('role_user', 'superadmin');
        }
    }



    public function configure(): void
    {
        $this->setTableWrapperAttributes([
            'default' => false,
            'class' => 'soft-scrollbar overflow-y-hidden shadow  border-b border-gray-200 dark:border-gray-700 sm:rounded-lg',
        ]);

        $this->setPerPageAccepted([5, 10, 50, 100]);
        $this->getPerPageDisplayedItemCount();
        $this->setPerPage(5);
        $this->setPageName('users'.$this->tipe);
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        $logic = [];

        if ($this->tipe === 'desa') {
            $logic = [

                Column::make("Desa", "desa.nama_desa"),
                 Column::make("Jabatan", "jabatan.nama")->searchable(),
            ];
        } else if ($this->tipe === 'kua') {

            $logic = [
                Column::make("KUA", "datakua.nama_kecamatan"),
                Column::make("Jabatan", "jabatan.nama")->searchable(),
            ];
        }

        return [
            Column::make("Id", "id"),
            Column::make("Email", "email")->searchable()
                ->sortable()->collapseOnTablet(),
            Column::make("Nama", "name")->searchable()
                ->sortable()->collapseOnTablet(),

            ...$logic,
            Column::make("Hak Akses", "role_user") ->format(
                fn($value, $row, Column $column) => Str::upper( $row->role_user)
            ),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            ComponentColumn::make('action', 'id')
                ->component('button')
                ->attributes(fn ($value, $row, Column $column) => [
                    'icon' => 'pencil',
                    'secondary',
                    'wire:click' => '$dispatch(\'handlerEdit\', { row: \'' . $row . '\' })',
                    'class' => 'space-x-2',
                ]),


        ];
    }
}
