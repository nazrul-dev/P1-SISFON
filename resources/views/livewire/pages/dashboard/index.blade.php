<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\{Desa, DataKua, DataNikah, DataN6};
use Carbon\Carbon;
new #[Layout('layouts.app')] class extends Component {
    public $data = [];
    public $withdesa = true;
    public function mount()
    {
        $user = auth()->user();
        $withdes;
        if ($user->tipe_user === 'desa' && $user->role_user !== 'superadmin') {
            $withdesa = false;
        } else {
            $withdesa = true;
        }

        if ($withdesa) {
            $this->data['chart_nikah_with_desa'] = $this->byGrafikNikahWithDesa();
            $this->data['chart_n6_with_desa'] = $this->byGrafikN6WithDesa();
        } else {
            $this->data['chart_nikah'] = $this->byGrafikNikah();
            $this->data['chart_n6'] = $this->byGrafikN6();
        }

        $this->withdesa = $withdesa;

        $this->data['desa'] = $this->getTotalDesa();
        $this->data['kua'] = $this->getTotalKUA();
        $this->data['nikah'] = $this->getTotalNikah($withdesa);
        $this->data['n6'] = $this->getTotalN6($withdesa);
    }

    public function byGrafikNikah()
    {
        $currentYear = now()->year;

        // Query to group and count data by month
        $result = DataNikah::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('strftime("%m", created_at)'))
            ->orderBy('month')
            ->get();
        $formattedResult = $result->pluck('count', 'month')->toArray();
        $formattedResult = array_replace(array_fill(1, 12, 0), $formattedResult);

        $data = [];
        foreach ($formattedResult as $k => $row) {
            $monthName = Carbon::createFromDate(null, $k, 1)->formatLocalized('%B');
            $data[$monthName] = $row;
        }

        $label = array_keys($data);
        $value = array_values($data);

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 400,
        ]);

        $qc->setConfig(
            '{
            "type": "line",
            "data": {
                "labels": ' .
                json_encode($label) .
                ',
                "datasets": [{
                    "label": "Grafik Laporan Data Nikah Tahun ' .
                now()->year .
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

        return $qc->getUrl();
    }

    public function byGrafikNikahWithDesa()
    {
        $currentYear = now()->year;

        // Query to group and count data by month and desa_id
        $result = DataNikah::with('desa')
            ->selectRaw(' desa_id, strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('desa_id', DB::raw('strftime("%m", created_at)'))
            ->orderBy('desa_id')
            ->orderBy('month')
            ->get();

        $data = [];
        foreach ($result as $row) {
            $desa_id = $row->desa->nama_desa;
            if (!isset($data[$desa_id])) {
                $data[$desa_id] = array_fill(1, 12, 0);
            }

            $data[$desa_id][(int) $row->month] = $row->count;
        }

        $dataset = [];
        foreach ($data as $key => $value) {
            $dataset[] = [
                'label' => $key,
                'data' => array_values($value),
            ];
        }

        $label = array_keys($data);

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 400,
        ]);

        $qc->setConfig(
            '{
                "type": "bar",
                "data": {
                    "labels": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                    "datasets": ' .
                json_encode($dataset) .
                '
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

        return $qc->getUrl();
    }

    public function byGrafikN6()
    {
        $currentYear = now()->year;

        // Query to group and count data by month
        $result = DataN6::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('strftime("%m", created_at)'))
            ->orderBy('month')
            ->get();
        $formattedResult = $result->pluck('count', 'month')->toArray();
        $formattedResult = array_replace(array_fill(1, 12, 0), $formattedResult);

        $data = [];
        foreach ($formattedResult as $k => $row) {
            $monthName = Carbon::createFromDate(null, $k, 1)->formatLocalized('%B');
            $data[$monthName] = $row;
        }

        $label = array_keys($data);
        $value = array_values($data);

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 400,
        ]);

        $qc->setConfig(
            '{
            "type": "line",
            "data": {
                "labels": ' .
                json_encode($label) .
                ',
                "datasets": [{
                    "label": "Grafik Laporan Data Nikah Tahun ' .
                now()->year .
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

        return $qc->getUrl();
    }

    public function byGrafikN6WithDesa()
    {
        $currentYear = now()->year;
        $result = DataN6::with('desa')
            ->selectRaw(' desa_id, strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('desa_id', DB::raw('strftime("%m", created_at)'))
            ->orderBy('desa_id')
            ->orderBy('month')
            ->get();

        $data = [];
        foreach ($result as $row) {
            $desa_id = $row->desa->nama_desa;
            if (!isset($data[$desa_id])) {
                $data[$desa_id] = array_fill(1, 12, 0);
            }

            $data[$desa_id][(int) $row->month] = $row->count;
        }

        $dataset = [];
        foreach ($data as $key => $value) {
            $dataset[] = [
                'label' => $key,
                'data' => array_values($value),
            ];
        }

        $label = array_keys($data);

        $qc = new QuickChart([
            'width' => 1366,
            'height' => 400,
        ]);

        $qc->setConfig(
            '{
                "type": "bar",
                "data": {
                    "labels": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                    "datasets": ' .
                json_encode($dataset) .
                '
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

        return $qc->getUrl();
    }

    public function getTotalDesa()
    {
        return Desa::count();
    }
    public function getTotalKUA()
    {
        return DataKua::count();
    }

    public function getTotalNikah($withdesa)
    {
        if (!$withdesa) {
            return DataNikah::where('desa_id', $user->desa_id)->count();
        } else {
            return DataNikah::count();
        }
    }
    public function getTotalN6($withdesa)
    {
        if (!$withdesa) {
            return DataN6::where('desa_id', $user->desa_id)->count();
        } else {
            return DataN6::count();
        }
    }
}; ?>

<div class="container mx-auto">
    <div class="space-y-5 gap-4 pb-10">
        <div class="grid grid-cols-4 gap-3">
            <div class="bg-white p-2 rounded-lg shadow-lg">
                <div class="flex items-center gap-2 text-lg font-bold border-b pb-2 mt-2">
                    <x-icon name="home" solid class="w-5 h-5" /> {{ $data['desa'] }}
                </div>
                <p class="font-semibold text-sm mt-2">
                    Total Desa Terdaftar</p>
            </div>
            <div class="bg-white p-2 rounded-lg shadow-lg">
                <div class="flex items-center gap-2 text-lg font-bold border-b pb-2 mt-2">
                    <x-icon solid name="office-building" class="w-5 h-5" /> {{ $data['kua'] }}
                </div>
                <p class="font-semibold text-sm mt-2">
                    Total KUA Terdaftar</p>
            </div>
            <div class="bg-white p-2 rounded-lg shadow-lg">
                <div class="flex items-center gap-2 text-lg font-bold border-b pb-2 mt-2">
                    <x-icon solid name="document-duplicate" class="w-5 h-5" /> {{ $data['nikah'] }}
                </div>
                <p class="font-semibold text-sm mt-2">
                    Total Dokumen Nikah</p>
            </div>
            <div class="bg-white p-2 rounded-lg shadow-lg">
                <div class="flex items-center gap-2 text-lg font-bold border-b pb-2 mt-2">
                    <x-icon solid name="document-duplicate" class="w-5 h-5" /> {{ $data['n6'] }}
                </div>
                <p class="font-semibold text-sm mt-2">
                    Total Dokumen N6</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-3">
            @if ($withdesa)
                <x-card title="Grafik Pernikahan Tahun {{ now()->year }} Berdasarkan Desa">
                    <img class="w-full" src="{{ $data['chart_nikah_with_desa'] }}" alt="">
                </x-card>
                <x-card title="Grafik Kematian Tahun {{ now()->year }} Berdasarkan Desa">
                    <img class="w-full" src="{{ $data['chart_n6_with_desa'] }}" alt="">
                </x-card>
            @else
                <x-card title="Grafik Pernikahan Tahun {{ now()->year }}">
                    <img class="w-full" src="{{ $data['chart_nikah'] }}" alt="">
                </x-card>
                <x-card title="Grafik Kematian Tahun {{ now()->year }}">
                    <img class="w-full" src="{{ $data['chart_n6'] }}" alt="">
                </x-card>
            @endif



        </div>
    </div>
</div>
