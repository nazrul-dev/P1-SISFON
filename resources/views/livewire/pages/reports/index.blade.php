<?php

use App\Models\DataNikah;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

use WireUi\Traits\Actions;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component {
    use Actions, WithPagination;
    public $chart;
    public $data = [];
    public $tab, $fdate, $edate, $gender, $by_filter, $fieldData;

    public function byAge()
    {
        $rentangUmur = range(16, 100);
        $jumlahOrangPerKelompok = [];
        $tanggalLahirColumn = $this->gender == 'Laki-laki' ? 'tanggal_lahir' : 'i_tanggal_lahir';
        foreach ($rentangUmur as $umur) {
            $jumlahOrang = DataNikah::selectRaw('COUNT(*) as total')


                ->whereRaw("YEAR(tanggal_akad) - YEAR($tanggalLahirColumn) = ?", [$umur])
->whereBetween('created_at', [$this->fdate, $this->edate])
->groupBy(DB::raw("YEAR(tanggal_akad) - YEAR($tanggalLahirColumn)"))
 ->pluck('total')
->first();

            if ($jumlahOrang >= 1) {
                $jumlahOrangPerKelompok[$umur] = $jumlahOrang;
            }
        }


        $dataCollection = collect($jumlahOrangPerKelompok);
        $labelsJson = json_encode($dataCollection->keys()->all());
        $valuesJson = json_encode($dataCollection->values()->all());
        $qc = new QuickChart([
            'width' => 1366,
            'height' => 728,
        ]);

        $qc->setConfig(
            '{
        type: "line",
        data: {
                labels: ' .
                    $labelsJson .
                    ',
                datasets: [{
                    "label": "Grafik Laporan Berdasarkan ' .
                    $this->by_filter .
                    ' ( ' .
                    $this->gender .
                    ' )",
                    data: ' .
                    $valuesJson .
                    '
                }]
            },
            "options": {
                    "scales": {

                        "yAxes": [
                            {

                                "ticks": {
                                    "beginAtZero": true,
                                    "userCallback": function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }
                        ]
                    }
                }

        }',
        );

        // Print the chart URL
        $this->chart = $qc->getUrl();
        $this->data = $jumlahOrangPerKelompok;
    }

    public function byTempatAkad()
    {
        $this->fieldData = 'status_tempat_akad';
        $query = DataNikah::selectRaw($this->fieldData . ', COUNT(*) as total')
            ->whereBetween('created_at', [$this->fdate, $this->edate])
            ->groupBy($this->fieldData)
            ->get()
            ->toArray();

        $dataCollection = collect($query);
        $label = $dataCollection->pluck($this->fieldData);
        $value = $dataCollection->pluck('total');

        $qc = new QuickChart([
            'width' => 1928,
            'height' => 728,
        ]);

        $qc->setConfig(
            '{
            "type": "line",
            "data": {
                "labels": ' .
                json_encode($label) .
                ',
                "datasets": [{
                    "label": "Grafik Laporan Berdasarkan ' .
                $this->by_filter .
                '",
                    "data": ' .
                json_encode($value) .
                '
                }]
            },
            "options": {
                    "scales": {

                        "yAxes": [
                            {

                                "ticks": {
                                    "beginAtZero": true,
                                    "userCallback": function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }
                        ]
                    }
                }
        }',
        );

        // Print the chart URL
        $this->chart = $qc->getUrl();
        $this->data = $query;
    }

    public function byStatusPerkawinan()
    {
        $fill = $this->gender == 'Laki-laki' ? 'status_perkawinan' : 'i_status_perkawinan';
        $this->fieldData = $fill;
        $query = DataNikah::selectRaw($fill . ', COUNT(*) as total')

            ->whereBetween('created_at', [$this->fdate, $this->edate])
            ->groupBy($fill)
            ->get()
            ->toArray();

        $dataCollection = collect($query);
        $label = $dataCollection->pluck($fill);
        $value = $dataCollection->pluck('total');

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 728,
        ]);

        $qc->setConfig(
            '{
            "type": "line",
            "data": {
                "labels": ' .
                json_encode($label) .
                ',
                "datasets": [{
                    "label": "Grafik Laporan Berdasarkan ' .
                $this->by_filter .
                ' ( ' .
                $this->gender .
                ' )",
                    "data": ' .
                json_encode($value) .
                '
                }]
            }
        }',
        );

        // Print the chart URL
        $this->chart = $qc->getUrl();
        $this->data = $query;
    }

    public function byPendidikan()
    {
        $fill = $this->gender == 'Laki-laki' ? 'pendidikan_terakhir' : 'i_pendidikan_terakhir';
        $this->fieldData = $fill;
        $query = DataNikah::selectRaw($fill . ', COUNT(*) as total')

            ->whereBetween('created_at', [$this->fdate, $this->edate])
            ->groupBy($fill)
            ->get()
            ->toArray();

        $dataCollection = collect($query);
        $label = $dataCollection->pluck($fill);
        $value = $dataCollection->pluck('total');

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 728,
        ]);

        $qc->setConfig(
            '{
            "type": "line",
            "data": {
                "labels": ' .
                json_encode($label) .
                ',
                "datasets": [{
                    "label": "Grafik Laporan Berdasarkan ' .
                $this->by_filter .
                ' ( ' .
                $this->gender .
                ' )",
                    "data": ' .
                json_encode($value) .
                '
                }]
            },
            "options": {
                    "scales": {

                        "yAxes": [
                            {

                                "ticks": {
                                    "beginAtZero": true,
                                    "userCallback": function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }
                        ]
                    }
                }
        }',
        );

        // Print the chart URL
        $this->chart = $qc->getUrl();
        $this->data = $query;
    }
    public function filter()
    {
        $validated = $this->validate([
            'fdate' => 'required',
            'edate' => 'required',
            'gender' => 'required',
            'by_filter' => 'required',
        ]);
        $this->reset('tab', 'data', 'fieldData');
        if ($this->by_filter === 'Usia') {
            $this->byAge();
        } elseif ($this->by_filter === 'Tempat Nikah') {
            $this->byTempatAkad();
        } elseif ($this->by_filter === 'Status Perkawinan') {
            $this->byStatusPerkawinan();
        } elseif ($this->by_filter === 'Pendidikan') {
            $this->byPendidikan();
        }
    }

    public function changeTab($tab)
    {
        $this->tab = $tab;
    }
}; ?>

<div class="container mx-auto">
    <div class="flex gap-2 ">
        <div class="w-72">
            <x-card title="Filter">
                <div class="grid gap-2">
                    <x-datetime-picker without-time label="Dari Tanggal" placeholder="Pilih Tanggal" wire:model="fdate" />
                    <x-datetime-picker without-time label="Sampai Tanggal" placeholder="Pilih Tanggal"
                        wire:model="edate" />
                    <x-select label="Jenis Kelamin" placeholder="Pilih salah satu" :options="['Laki-laki', 'Perempuan']"
                        wire:model="gender" />
                    <x-select label="Filter Berdasarkan" placeholder="Pilih salah satu" :options="['Tempat Nikah', 'Status Perkawinan', 'Usia', 'Pendidikan']"
                        wire:model="by_filter" />

                    <x-button positive wire:click="filter" class="text-left">
                        <x-slot name="label">
                            <div class="text-center  w-full">
                                Filter
                            </div>
                        </x-slot>
                    </x-button>
                </div>
            </x-card>
        </div>
        <div class="flex-1">
            <div class="flex gap-2 mb-2">
                <x-button wire:click="changeTab('I')" :secondary="$tab !== 'I'" :positive="$tab === 'I'" class="text-left ">
                    <x-slot name="label">
                        <div class="text-left  w-full">
                            I. Statistik
                        </div>
                    </x-slot>
                </x-button>
                <x-button wire:click="changeTab('II')" :secondary="$tab !== 'II'" :positive="$tab === 'II'" class="text-left ">
                    <x-slot name="label">
                        <div class="text-left  w-full">
                            II. Data
                        </div>
                    </x-slot>
                </x-button>
                <x-button wire:click="changeTab('III')" :secondary="$tab !== 'III'" :positive="$tab === 'III'" class="text-left ">
                    <x-slot name="label">
                        <div class="text-left  w-full">
                            III. Grafik
                        </div>
                    </x-slot>
                </x-button>
            </div>
            <x-card title="Laporan Berdasarkan Usia">




                <div class="border-b pb-5 border-dashed">
                    @isset($fdate)
                        <x-badge lg flat primary label=" Rentang Tanggal :  {{ $fdate }} - {{ $edate }} " />
                    @endisset

                    @isset($by_filter)
                        <x-badge lg flat primary label=" Filter  : Berdasarkan {{ $by_filter }}" />
                    @endisset
                    @isset($gender)
                        <x-badge lg flat primary label=" Gender  : {{ $gender }}" />
                    @endisset

                </div>

                @if ($data && $tab)
                    @if ($tab === 'I')
                        <livewire:pages.reports.statistik :field="$fieldData" :type="$by_filter" :props="$data" />
                    @elseif ($tab === 'II')
                        <livewire:pages.reports.data :field="$fieldData" :type="$by_filter" :props="$data" />
                    @elseif ($tab === 'III')
                        <livewire:pages.reports.grafik :props="$chart" />
                    @endif
                @elseif(!$data && $tab)
                    <div class="h-[70vh] flex flex-col items-center justify-center">
                        <div class="font-bold text-lg animate-pulse">
                            Data Kosong
                        </div>
                    </div>
                @else
                    <div class="h-[70vh] flex flex-col items-center justify-center">
                        <div class="font-bold text-lg mb-5">
                            Pilih tipe Tab terlebih dahulu
                        </div>
                        <div class="flex gap-2 mb-2">
                            <x-button wire:click="changeTab('I')" :secondary="$tab !== 'I'" :positive="$tab === 'I'"
                                class="text-left ">
                                <x-slot name="label">
                                    <div class="text-left  w-full">
                                        I. Statistik
                                    </div>
                                </x-slot>
                            </x-button>
                            <x-button wire:click="changeTab('II')" :secondary="$tab !== 'II'" :positive="$tab === 'II'"
                                class="text-left ">
                                <x-slot name="label">
                                    <div class="text-left  w-full">
                                        II. Data
                                    </div>
                                </x-slot>
                            </x-button>
                            <x-button wire:click="changeTab('III')" :secondary="$tab !== 'III'" :positive="$tab === 'III'"
                                class="text-left ">
                                <x-slot name="label">
                                    <div class="text-left  w-full">
                                        III. Grafik
                                    </div>
                                </x-slot>
                            </x-button>
                        </div>
                    </div>
                @endif

            </x-card>
        </div>
    </div>
</div>
