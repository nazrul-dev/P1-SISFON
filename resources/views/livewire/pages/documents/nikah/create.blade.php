<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{User, Village, Desa, DataNikah, DataN6};
use WireUi\Traits\Actions;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions;
    public $tab = 'I';
    public $form = false;

    public $data = [
        'I' => [
            'desa_id' => 1,
            'ttd_aparat_id' => 1,
            'nomor_surat_keluar_s' => '12312312312',
            'tanggal_akad' => '2023-11-27',
            'jam_akad' => '00:10',
            'status_tempat_akad' => 'Masjid/Musholla',
            'alamat_tempat_akad' => 'Buntulia',
            'saksi1' => 'Burhan',
            'saksi2' => 'Darwis',
            'kua_pencatatan' => 5,
            'kecamatan_kl_id' => null,
            'nama_kepala_kl_kua' => null,
            'nip_kepala_kl_kua' => null,
            'tanggal_diterima_kua' => '2023-11-28',
            'tanggal_surat_keluar' => '2023-11-28',
            'status_pemohon' => 'calon suami',
        ],
        'II' => [
            'nama' => 'NASRUL',
            'pendidikan_terakhir' => 'S1',
            'nama_panggilan' => 'Arul',
            'tempat_lahir' => 'Popayato',
            'tanggal_lahir' => '1997-03-07',
            'nik' => '75049283232423',
            'status_warganegara' => 'WNI',
            'agama' => 'Islam',
            'pekerjaan_id' => 70,
            'nomor_handphone' => '6282291462750',
            'village_id' => '5208042012',
            'status_perkawinan' => 'Duda (Cerai Mati)',
            'istri_ke' => 2,
            'n6_id' => null,
            'alamat' => 'Popayato',
            'gelar_depan' => null,
            'gelar_belakang' => 'S,.Kom',
            'kecamatan_id' => '520804',
            'kabupaten_id' => '5208',
            'provinsi_id' => '52',
        ],
        'III' => [
            'i_nama' => 'WULANDARI',
            'i_pendidikan_terakhir' => 'SMA/Sederajat',
            'i_nama_panggilan' => 'ULAN',
            'i_tempat_lahir' => 'Marisa',
            'i_tanggal_lahir' => '2000-11-27',
            'i_nik' => '75094534342',
            'i_status_warganegara' => 'WNI',
            'i_agama' => 'Islam',
            'i_pekerjaan_id' => 70,
            'i_nomor_handphone' => '213123',
            'i_village_id' => '5208042012',
            'i_status_perkawinan' => 'Perawan',
            'i_suami_ke' => 0,
            'i_n6_id' => null,
            'i_alamat' => 'Buntulia',
            'i_gelar_depan' => null,
            'i_gelar_belakang' => null,
            'i_kecamatan_id' => '520804',
            'i_kabupaten_id' => '5208',
            'i_provinsi_id' => '52',
        ],
        'IV' => [
            's_yatim' => false,
            's_piatu' => false,
            'sa_nama' => 'FATAHUDDIN RAHIM',
            'si_nama' => 'WISNA LADAWING',
            'sa_tipe_bin' => null,
            'sa_alamat' => 'Popayato',
            'si_tipe_bin' => null,
            'si_alamat' =>'Popayato',
        ],
        'V' => [
            'i_yatim' => true,
            'i_piatu' => false,
            'ia_nama' => 'HASAN INAKU',
            'ii_nama' => 'ARASWATI',
            'ia_tipe_bin' => null,
            'ia_alamat' => null,
            'ii_tipe_binti' => null,
            'ii_alamat' => 'Buntulia Tengah',
        ],
        'VI' => [
            'n6_nama' => 'FULAN',
            'n6_pendidikan_terakhir' => 'SD/Sederajat',
            'n6_nama_panggilan' => 'ULAN',
            'n6_binti' => 'RENA',
            'n6_tempat_lahir' => 'Buntulia',
            'n6_tanggal_lahir' => '2000-11-28',
            'n6_nik' => '7509343434',
            'n6_status_warganegara' => 'WNI',
            'n6_agama' => 'Islam',
            'n6_pekerjaan_id' => 44,
            'n6_village_id' => '1671031001',
            'n6_nomor_surat_keluar' => '2343242342323',
            'n6_tanggal_meninggal' => '2023-11-27',
            'n6_alamat_tempat_meninggal' => 'Buntulia',
            'n6_tipe_bin' => null,
            'n6_gelar_depan' => null,
            'n6_gelar_belakang' => null,
        ],
        'VII' => [
            // 'n6_nama' => 'asdasdas',
            // 'n6_pendidikan_terakhir' => 'SD/Sederajat',
            // 'n6_nama_panggilan' => 'asdasda',
            // 'n6_binti' => 'sadasdas',
            // 'n6_tempat_lahir' => 'asdasdas',
            // 'n6_tanggal_lahir' => '2023-11-28',
            // 'n6_nik' => '2312312',
            // 'n6_status_warganegara' => 'WNI',
            // 'n6_agama' => 'Kong Hu Cu',
            // 'n6_pekerjaan_id' => 44,
            // 'n6_village_id' => '1671031001',
            // 'n6_nomor_surat_keluar' => '2343242342323',
            // 'n6_tanggal_meninggal' => '2023-11-27',
            // 'n6_alamat_tempat_meninggal' => 'asdasdas',
            // 'n6_tipe_bin' => null,
            // 'n6_gelar_depan' => 'Dr',
            // 'n6_gelar_belakang' => null,
        ],
    ];

    #[On('form-change')]
    public function updatedFormFromDispatch()
    {
        $this->form = !$this->form;
    }

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
        // $this->js("alert('Post saved!')");
    }

    #[On('finish')]
    public function finish($data, $tab)
    {
        $this->data[$tab] = $data;
        $this->storeData();
    }

    #[On('creating-data')]
    public function handlerAdd()
    {
        $this->reset('data');
        $this->resetErrorBag();
        $this->tab = 'I';
        $this->form = true;
    }

    public function getLastNumber($desaID)
    {
        $arr = [
            'nomor_terakhir' => 0,
            'nomor_urut' => 1,
        ];
        $data_terakhir = DataN6::where('desa_id', $desaID)->count();
        if ($data_terakhir) {
            $arr['nomor_terakhir'] = $data_terakhir;
            $arr['nomor_urut'] = $data_terakhir + 1;
        }
        return $arr;
    }

    public function storeData()
    {
        DB::beginTransaction();

        try {
            $desa = Desa::find($this->data['I']['desa_id']);
            $data_terakhir = DataNikah::where('desa_id', $desa->id)->count();
            if ($data_terakhir) {
                $this->data['I']['nomor_terakhir'] = $data_terakhir;
                $this->data['I']['nomor_urut'] = $data_terakhir + 1;
            } else {
                $this->data['I']['nomor_terakhir'] = 0;
                $this->data['I']['nomor_urut'] = 1;
            }
            $originalData = $this->data;

            unset($this->data['I']['kecamatan_kl_id']);
            unset($this->data['I']['nama_kepala_kl_kua']);
            unset($this->data['I']['nip_kepala_kl_kua']);

            // if (isset($this->data['I']['nomor_surat_keluar_s'])) {
            //     $this->data['I']['nomor_surat_keluar_s'] = $desa->n1 . $this->data['I']['nomor_surat_keluar_s'];
            // }
            // if (isset($this->data['I']['nomor_surat_keluar_i'])) {
            //     $this->data['I']['nomor_surat_keluar_i'] = $desa->n1 . $this->data['I']['nomor_surat_keluar_i'];
            // }

            $preData = [
                'tanggal_surat_keluar' => $this->data['I']['tanggal_surat_keluar'],
                'ttd_aparat_id' => $this->data['I']['ttd_aparat_id'],
            ];

            if (isset($this->data['VI']) && isset($this->data['VI']['n6_nomor_surat_keluar'])) {
                // $this->data['VI']['n6_nomor_surat_keluar'] = $desa->n6 . $this->data['VI']['n6_nomor_surat_keluar'];

                $villID = Village::where('code', $this->data['VI']['n6_village_id'])->first();
                $location = \Indonesia::findVillage($villID->id, ['province', 'city', 'district', 'district.city', 'district.city.province']);
                // $nomorUrutN6S = $this->getLastNumber($desa->id);
                $dataN6 = DataN6::create([...$this->data['VI'], 'tanggal_surat_keluar' => $this->data['I']['tanggal_surat_keluar'], ...$preData, 'n6_jenis_kelamin' => 'P', 'desa_id' => $desa->id, 'n6_kecamatan_id' => $location->district->code, 'n6_kabupaten_id' => $location->city->code, 'n6_provinsi_id' => $location->city->province->code]);
                $this->data['II']['n6_id'] = $dataN6->id;
                unset($this->data['VI']);
            }

            if (isset($this->data['VII']) && isset($this->data['VII']['n6_nomor_surat_keluar'])) {
                // $this->data['VII']['n6_nomor_surat_keluar'] = $desa->n6 . $this->data['VII']['n6_nomor_surat_keluar'];

                $villID = Village::where('code', $this->data['VII']['n6_village_id'])->first();
                $location = \Indonesia::findVillage($villID->id, ['province', 'city', 'district', 'district.city', 'district.city.province']);
                // $nomorUrutN6I = $this->getLastNumber($desa->id);
                $dataN6 = DataN6::create([...$this->data['VII'], 'tanggal_surat_keluar' => $this->data['I']['tanggal_surat_keluar'], ...$preData,  'n6_jenis_kelamin' => 'L', 'desa_id' => $desa->id, 'n6_kecamatan_id' => $location->district->code, 'n6_kabupaten_id' => $location->city->code, 'n6_provinsi_id' => $location->city->province->code]);
                $this->data['III']['i_n6_id'] = $dataN6->id;
                unset($this->data['VII']);
            }

            $request = [];
            foreach ($this->data as $data) {
                foreach ($data as $key => $value) {
                    if (isset($value)) {
                        $request[$key] = $value;
                    }
                }
            }



            $results = DataNikah::create($request);
            DB::commit();
            $this->reset(['data', 'tab']);
            $this->form = false;
            $this->dialog()->confirm([
                'closeButton' => false,
                'title' => ' Data Nikah berhasil disimpan',
                'description' => ' Silahkan pilih  Salah satu  Option yang anda inginkan',
                'icon' => 'success',
                'accept' => [
                    'label' => 'Print Dan Keluar',
                    'method' => 'afterStoreAndPrint',
                    'params' => $results->id,
                ],
                'reject' => [
                    'label' => 'Tambah Data kembali',
                    'method' => 'afterStore',
                ],
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            $this->notification([
                'title' => 'Data Nikah simpan!',
                'description' =>  $e->getMessage().', harap refresh kembali halaman',
                'icon' => 'error',
            ]);
        }
    }

    public function afterStore($id)
    {
        return $this->redirect(route('document.create.nikah'), navigate: false);
    }

    public function afterStoreAndPrint($id)
    {

        $url = app('DataNikahPrinter')->run($id);
        $filename = pathinfo($url, PATHINFO_FILENAME);
        $filename = basename($url);
        $this->dispatch('downloadZip', url: '/'.$filename, redirectPath:route('document', ['tab' => 'nikah']));
    }
}; ?>
<div>



    <div class="w-2/3 mx-auto flex items-start gap-2 ">
        <div class="flex flex-col mb-2 gap-2">
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
            <x-button :secondary="$tab !== 'IV'" :positive="$tab === 'IV'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        IV. Orang Tua Suami
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'V'" :positive="$tab === 'V'" class="text-left">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        V. Orang Tua Istri
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'VI'" :positive="$tab === 'VI'"
                class="text-left {{ isset($data['II']['status_perkawinan']) == 'Duda (Cerai Mati)' ? 'block' : 'hidden' }}">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        VI. N6 Mantan Istri
                    </div>
                </x-slot>
            </x-button>
            <x-button :secondary="$tab !== 'VII'" :positive="$tab === 'VII'"
                class="text-left {{ isset($data['III']['i_status_perkawinan']) == 'Janda (Cerai Mati)' ? 'block' : 'hidden' }}">
                <x-slot name="label">
                    <div class="text-left  w-full">
                        VII. N6 Mantan Suami
                    </div>
                </x-slot>
            </x-button>




        </div>
        <div class="pb-10 flex-1">
            @if ($tab === 'I')
                <livewire:pages.documents.nikah.form-add.tab1 :props="$data" />
            @elseif ($tab === 'II')
                <livewire:pages.documents.nikah.form-add.tab2 :props="$data" />
            @elseif ($tab === 'III')
                <livewire:pages.documents.nikah.form-add.tab3 :props="$data" />
            @elseif ($tab === 'IV')
                <livewire:pages.documents.nikah.form-add.tab4 :props="$data" />
            @elseif ($tab === 'V')
                <livewire:pages.documents.nikah.form-add.tab5 :props="$data" />
            @elseif ($tab === 'VI' && $data['II']['status_perkawinan'] === 'Duda (Cerai Mati)')
                <livewire:pages.documents.nikah.form-add.tab6 :props="$data" />
            @elseif ($tab === 'VII' && $data['III']['i_status_perkawinan'] === 'Janda (Cerai Mati)')
                <livewire:pages.documents.nikah.form-add.tab7 :props="$data" />
            @endif

        </div>
    </div>

</div>
