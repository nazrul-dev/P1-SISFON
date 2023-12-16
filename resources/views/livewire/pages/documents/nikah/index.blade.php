<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\{DataNikah};
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component {

    use Actions, WithPagination;

    #[On('handlerPrint')]
    public function handlerPrint($id)
    {
        $url = app('DataNikahPrinter')->run($id);
        $filename = pathinfo($url, PATHINFO_FILENAME);
        $filename = basename($url);
        $this->dispatch('downloadZip', url: $filename);
    }

    #[On('handlerEdit')]
    public function handlerEdit($id)
    {
        $blocking_array = ['id', 'diinput_dari', 'nomor_terakhir', 'nomor_urut', 'created_at', 'updated_at', 'deleted_at'];
        $i_array = ['desa_id', 'tanggal_surat_keluar', 'nomor_surat_keluar', 'tanggal_akad', 'ttd_aparara', 'jam_akad', 'status_tempat_akad', 'alamat_tempat_akad', 'ttd_aparat_id', 'saksi1', 'saksi2', 'kua_pencatatan', 'tanggal_diterima_kua'];

        $data = DataNikah::find($id)->toArray();
        $mappings = [];
        foreach ($data as $key => $value) {
            if ($key === 'n6_id') {
                $mappings['II'][$key] = $value;
            } elseif (preg_match('/^i_/', $key)) {
                $mappings['III'][$key] = $value;
            } elseif (preg_match('/^sa_/', $key) || preg_match('/^si_/', $key)) {
                $mappings['IV'][$key] = $value;
            } elseif (preg_match('/^ii_/', $key) || preg_match('/^ia_/', $key)) {
                $mappings['V'][$key] = $value;
            } elseif (preg_match('/^n6_/', $key) && $key !== 'n6_id') {
                $mappings['V'][$key] = $value;
            } elseif (in_array($key, $i_array)) {
                $mappings['I'][$key] = $value;
            } else {
                if (!in_array($key, $blocking_array)) {
                    $mappings['II'][$key] = $value;
                }
            }
        }

        $this->dispatch('editing-data', data: $mappings, id: $data['id']);
    }

    public function handleForm()
    {
        return $this->redirect(route('document.nikah.add'), navigate: false);
    }
}; ?>

<div>
    <x-card>
        <x-slot name="title">
            <div class="capitalize">
                Data Nikah
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.document-nikah-table />


        </div>
    </x-card>


</div>
