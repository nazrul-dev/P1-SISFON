<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions, WithPagination;
    public string $tab = 'akun';

    public $name, $role_user, $email, $nip, $telepon, $jabatan_id, $password, $newpassword;
    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->role_user = $user->role_user;
        $this->email = $user->email;
        $this->nip = $user->nip;
        $this->telepon = $user->telepon;
        $this->jabatan_i = $user->jabatan_id;
    }
    public function changeTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function handleFormAkun()
    {
        try {
            $password = [];
            if ($this->password && $this->newpassword) {
                $password = [
                    'password' => 'required|min:3|current_password',
                    'newpassword' => 'required|min:3',
                    'telepon' => 'nullable',
                    'nip' => 'nullable',
                ];
            }
            $validated = $this->validate([...$password, 'name' => 'required', 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->id())]]);
            if ($this->password && $this->newpassword) {
                $validated['password'] = Hash::make($validated['newpassword']);
                unset($validated['newpassword']);
            }

            User::find(auth()->id())->update($validated);
            $this->notification([
                'title' => 'Update Akun !',
                'description' => ' Update Akun Sukses',
                'icon' => 'success',
            ]);
        } catch (QueryException $th) {
            $this->notification([
                'title' => 'Update Akun !',
                'description' => ' Update Akun Gagal',
                'icon' => 'error',
            ]);
        }
    }
}; ?>


<div class="container w-2/3 mx-auto">
    <div class="flex flex-col gap-2">

        <div>
            <x-button wire:click="changeTab('akun')" :secondary="$tab !== 'akun'" :positive="$tab === 'akun'" label="Akun" icon="user" />

            {{-- <x-button wire:click="changeTab('aplikasi')" :secondary="$tab !== 'aplikasi'" :positive="$tab === 'aplikasi'" icon="desktop-computer"
                label="Aplikasi" /> --}}
            <x-button icon="database" wire:click="changeTab('database')" :secondary="$tab !== 'database'" :positive="$tab === 'database'"
                label="Database" />

        </div>
        @if ($tab === 'akun')
            <x-card>
                <x-slot name="title">
                    <div class="capitalize">
                        Pengaturan Akun
                    </div>
                </x-slot>
                <x-slot name="action">
                    <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <x-button label="Simpan" wire:click="handleFormAkun()" positive icon="save" />
                    </button>
                </x-slot>
                <div class="grid grid-cols-2 gap-2">

                    <x-input wire:model="name" label="Nama" />
                    <x-input wire:model="email" label="Email" />
                    <x-input wire:model="telepon" label="Telepon" />
                    <x-input wire:model="nip" label="NIP" />


                    <x-inputs.password hint="Silahkan isi password jika anda ingin menggantinya" wire:model="password"
                        label="Password Lama" />

                    <x-inputs.password wire:model="newpassword" label="Password Baru" />


                </div>
            </x-card>
        @elseif ($tab === 'aplikasi')
            <x-card>
                <x-slot name="title">
                    <div class="capitalize">
                        Pengaturan aplikasi
                    </div>
                </x-slot>
                <x-slot name="action">
                    <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <x-button label="Simpan" wire:click="handleForm()" positive icon="save" />
                    </button>
                </x-slot>
                <div class="grid grid-cols-2 gap-2">
                    <x-select
                        hint="Mengaktifkan fitur ini akan meminta konfirmasi dari Admin Atau Operator KUA untuk menyetujui pnegedtant Semua Dokumen"
                        label="Aktifkan Konfirmasi Edit Dokumen" placeholder="Pilih salah satu" :options="['Ya', 'Tidak']" />
                    <x-input wire:model="name" label="Aktifkan Konfirmasi Edit Dokumen" />
                    <x-select label="Hak Akses" placeholder="Pilih salah satu" :options="['Asia/Makassar', 'Asia/Jakarta', 'Asia/Jayapura']" />
                    <x-input label="Lisensi aplikasi" />
                    <x-input wire:model="nip" label="Versi Apllikasi" />
                    <x-input wire:model="nip" label="Versi Framework" />
                    <x-input wire:model="nip" label="Versi PHP" />
                    <x-input wire:model="nip" label="Pembuat aplikasi" />




                </div>
            </x-card>
        @elseif ($tab === 'database')
        <x-card>
            <x-slot name="title">
                <div class="capitalize">
                    Pengaturan Database
                </div>
            </x-slot>
            <x-slot name="action">
                <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <x-button label="Simpan" wire:click="handleFormAkun()" positive icon="save" />
                </button>
            </x-slot>
            <div class="grid grid-cols-2 gap-2 mb-5">

                <x-button label="Reset Dokumen" wire:click="handleFormAkun()" positive icon="save" />
                <x-button label="Reset Master" wire:click="handleFormAkun()" positive icon="save" />
                <x-button label="Reset Pengguna" wire:click="handleFormAkun()" positive icon="save" />
                <x-button negative label="Reset Semua" wire:click="handleFormAkun()" positive icon="save" />



            </div>

            <div class="flex justify-between items-end gap-2 mt-5 border-t pt-5">
                <div class="flex-1">
                    <x-button label="Backup Database" class="w-full" wire:click="handleFormAkun()" positive icon="save" />
                </div>
                <div class="w-1/2">
                    <x-input type="file" wire:model="name" label="Restore Database" />
                </div>
            </div>
        </x-card>
        @endif

    </div>

</div>
