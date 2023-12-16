<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{Desa};

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class DesaTable extends DataTableComponent
{


    public string $tableName = 'desas';



    public function builder(): Builder
    {

        return Desa::query();
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
        $this->setPageName('desa');
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id"),
            Column::make("Nama Desa", "nama_desa",)->searchable()->sortable(),
            Column::make("Kepala Desa", "kepala_desa")->searchable()->sortable(),
            Column::make("N1", "n1")->searchable(),
            Column::make("N6", "n6")->searchable(),
            Column::make("Kode POS", "kode_pos")->searchable(),
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
