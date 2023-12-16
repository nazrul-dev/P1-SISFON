<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{DataN6};

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class DocumentNsixTable extends DataTableComponent
{


    public string $tableName = 'data_n6';
    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];



    public function builder(): Builder
    {

        return DataN6::query();
    }


    public function exportSelected()
    {
        dd($this->getSelected());
        // $this->clearSelected();
    }
    public function configure(): void
    {
        $this->setTableWrapperAttributes([
            'default' => false,
            'class' => 'soft-scrollbar overflow-y-hidden shadow  border-b border-gray-200 dark:border-gray-700 sm:rounded-lg',
        ]);
        $this->setBulkActions([
            'exportSelected' => 'Export',
        ]);

        $this->setDefaultSort('created_at', 'desc');
        $this->setPerPageAccepted([5, 10, 50, 100]);
        $this->getPerPageDisplayedItemCount();
        $this->setPerPage(5);
        $this->setPageName('datan6');
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {


        return [
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('components.buttonnikah')->with(
                        [
                            'id' => $row->id,
                            'type' => 'n6'


                        ]
                    )
                )->html(),
            Column::make("Id", "id"),
            Column::make("Nomor Surat Keluar", "n6_nomor_surat_keluar")->searchable(),
            Column::make("Tanggal Surat Keluar", "tanggal_surat_keluar")->format(
                fn ($value, $row, Column $column) => $row->tanggal_surat_keluar->format('Y-m-d')
            ),
            Column::make("Di TTD Aparat", "ttd_aparat.nama",)->searchable()->sortable()->eagerLoadRelations(),
            Column::make("Tercatat Dari Desa", " desa.nama_desa",)->searchable()->sortable()->eagerLoadRelations(),
            Column::make("Created at", "created_at")
                ->sortable(),
            // Column::make("Updated at", "updated_at")->sortable(),



        ];
    }
}
