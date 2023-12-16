<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\{DataNikah};
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions, WithPagination;

    public $tab = 'I';
    public $data = [
        'I' => [],
        'II' => [],
        'III' => [],
        'IV' => [],
        'V' => [],
        'VI' => [],
    ];

    #[On('back-tab')]
    public function backTab($data, $tab)
    {
        $this->tab = $tab;
        $this->data = $data;
    }

    #[On('next-tab')]
    public function nextTab($data, $tab, $nextTab)
    {
        $this->tab = $nextTab;
        $this->data[$tab] = $data;
    }

    #[On('finish')]
    public function finish($data)
    {
        $this->data['VI'] = $data;
        $this->storeData();
    }

    #[On('creating-data')]
    public function handlerAdd()
    {
        $this->reset('data');
        $this->resetErrorBag();
        $this->tab = 'I';
    }

    #[On('editing-data')]
    public function handlerEdit($data)
    {
        $this->tab = 'I';
        $this->resetErrorBag();
        $this->data = $data;
    }

    public function mount($id)
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

        $this->data = $mappings;
    }
}; ?>
<div class="container  mx-auto">

    <div class="flex gap-2 w-full ">
        <div class="flex w-48 flex-col mb-2 gap-2">
            <x-button :secondary="$tab !== 'I'" :positive="$tab === 'I'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        I. Surat
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'II'" :positive="$tab === 'II'" class="text-left">
                <x-slot name="label">
                    <div class="text-left w-full">
                        II. Suami
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'III'" :positive="$tab === 'III'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        III. Istri
                    </div>
                </x-slot>
            </x-button>
            <x-button  wire:click="$dispatch('on-save')" :secondary="$tab !== 'IV'" :positive="$tab === 'IV'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        IV. Orang Tua Suami
                    </div>
                </x-slot>
            </x-button>
            <x-button wire:click=""  :secondary="$tab !== 'V'" :positive="$tab === 'V'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        V. Orang Tua Istri
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'VI'" :positive="$tab === 'VI'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        VI. N6
                    </div>
                </x-slot>
            </x-button>

        </div>
        <div class="flex-1">
            @if ($tab === 'I')
                <livewire:documents.nikah.form.tab1 :props="$data" />
            @elseif ($tab === 'II')
                <livewire:documents.nikah.form.tab2 :props="$data" />
            @elseif ($tab === 'III')
                <livewire:documents.nikah.form.tab3 :props="$data" />
            @elseif ($tab === 'IV')
                <livewire:documents.nikah.form.tab4 :props="$data" />
            @elseif ($tab === 'V')
                <livewire:documents.nikah.form.tab5 :props="$data" />
            @elseif ($tab === 'VI')
                <livewire:documents.nikah.form.tab6 :props="$data" />
            @endif
        </div>
        <div class="flex w-48 flex-col mb-2 gap-2">
            <x-button :secondary="$tab !== 'I'" :positive="$tab === 'I'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        Print Dokumen
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'II'" :positive="$tab === 'II'" class="text-left">
                <x-slot name="label">
                    <div class="text-left w-full">
                        Hapus Dokumen
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'II'" :positive="$tab === 'II'" class="text-left">
                <x-slot name="label">
                    <div class="text-left w-full">
                        Simpan Perubahan
                    </div>
                </x-slot>
            </x-button>


        </div>
    </div>

</div>
