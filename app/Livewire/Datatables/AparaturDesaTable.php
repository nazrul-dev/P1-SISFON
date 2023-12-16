<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{AparaturDesa, Datakua};

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class AparaturDesaTable extends DataTableComponent
{



    public string $tableName = 'aparatur_desas';



    public function builder(): Builder
    {

        return AparaturDesa::query();
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
        $this->setPageName('datakuas');
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id"),
            Column::make("nama", "nama")->searchable()->sortable(),
            Column::make("Jabatan", "jabatan.nama")->searchable()->sortable(),
            Column::make("Desa", "desa.nama_desa")->searchable()->sortable(),
            Column::make("NIP", "nip")->searchable(),
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
