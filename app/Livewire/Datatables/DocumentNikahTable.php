<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\{DataNikah, Desa};

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class DocumentNikahTable extends DataTableComponent
{


    public string $tableName = 'data_nikahs';
    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];



    public function builder(): Builder
    {

        return DataNikah::query();
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
        $this->setPageName('datanikah');
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
                            'type' => 'nikah'

                        ]
                    )
                )->html(),
            Column::make("Id", "id"),

            Column::make("Nomor Surat Keluar_s", "nomor_surat_keluar_s")->hideIf(true)->searchable(),
            Column::make("Nomor Surat Keluar_i", "nomor_surat_keluar_i")->hideIf(true)->searchable(),

            Column::make("Nomor Surat Keluar", "status_pemohon")->format(function ($value, $row, Column $column) {
                if ($row->status_pemohon === 'calon istri') {
                    return $row->nomor_surat_keluar_i;
                } elseif($row->status_pemohon === 'calon suami') {
                    return $row->nomor_surat_keluar_s;
                }else{
                    return $row->nomor_surat_keluar_i.'<br/>'.$row->nomor_surat_keluar_s;
                }
            })->searchable()->html(),
            Column::make("KUA Pencatatan", "datakua.nama_kecamatan",)->searchable()->sortable()->eagerLoadRelations(),
            Column::make("Tanggal Surat Keluar", "tanggal_surat_keluar")->format(
                fn ($value, $row, Column $column) => $row->tanggal_surat_keluar->format('Y-m-d')
            ),
            Column::make("Tanggal Akad", "tanggal_akad")
                ->format(
                    fn ($value, $row, Column $column) => $row->tanggal_akad->format('Y-m-d') . '  ' . $row->jam_akad
                ),


            Column::make("Di TTD Aparat", "ttd_aparat.nama",)->searchable()->sortable()->eagerLoadRelations(),
            Column::make("Tercatat Dari Desa", " desa.nama_desa",)->searchable()->sortable()->eagerLoadRelations(),

            Column::make("Created at", "created_at")
                ->sortable(),

            // Column::make("Updated at", "updated_at")->sortable(),



        ];
    }
}
