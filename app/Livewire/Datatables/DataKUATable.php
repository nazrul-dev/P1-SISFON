<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{Datakua};

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class DataKUATable extends DataTableComponent
{



    public string $tableName = 'datakuas';



    public function builder(): Builder
    {

        return Datakua::query();
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
            Column::make("KUA", "nama_kecamatan")->searchable()->sortable(),
            Column::make("Nama Kepala KUA", "nama_kepala_kua")->searchable(),
            Column::make("NIP Kepala KUA", "nip")->searchable(),
            Column::make("Alamat KUA", "alamat_kua"),
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
