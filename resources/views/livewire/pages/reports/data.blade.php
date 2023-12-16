<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
new class extends Component {
    public $props;
    public $type, $field;
    public $i = 1;
}; ?>
<div class=" mt-5 h-[70vh] overflow-y-auto p-2 scroll-smooth">
    {{-- @isset($jumlahOrangPerKelompok)
        @foreach ($jumlahOrangPerKelompok as $k => $v)
            @if ($v >= 1)
                <div class="bg-gray-100 p-2 border shadow rounded-lg flex flex-col items-center justify-center">
                    <div style="--umur: {{ $k }};" class="umur text-center font-bold "
                        data-value="{{ $k }}">
                        {{ $v }} Orang
                    </div>
                    <div class="text-center text-sm">
                        Umur <x-badge flat negative label="{{ $k }}" /> Tahun
                    </div>
                </div>
            @endif
        @endforeach
    @endisset --}}


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Data
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah
                    </th>

                </tr>
            </thead>
            <tbody>
                @isset($props)
                    @if ($type !== 'Usia')
                        @foreach ($props as $v)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $i++ }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $v[$this->field] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $v['total'] }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($props as $k => $v)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $i++ }}
                                </th>
                                <td class="px-6 py-4">
                                    Umur {{ $k }} Tahun
                                </td>
                                <td class="px-6 py-4">
                                    {{ $v }} Orang
                                </td>
                            </tr>
                        @endforeach
                    @endif

                @endisset


            </tbody>
        </table>
    </div>


    {{-- <div class="bg-gray-100 p-2 border shadow rounded-lg flex flex-col items-center justify-center">
        <div class="text-center font-bold ">
            19.000 Orang
        </div>
        <div class="text-center text-sm">
            Moshulla
        </div>
    </div>
    <div class="bg-gray-100 p-2 border shadow rounded-lg flex flex-col items-center justify-center">
        <div class="text-center font-bold ">
            19.000 Orang
        </div>
        <div class="text-center text-sm">
            Janda
        </div>
    </div>
    <div class="bg-gray-100 p-2 border shadow rounded-lg flex flex-col items-center justify-center">
        <div class="text-center font-bold ">
            19.000 Orang
        </div>
        <div class="text-center text-sm">
            Perjaka
        </div>
    </div>
    <div class="bg-gray-100 p-2 border shadow rounded-lg flex flex-col items-center justify-center">
        <div class="text-center font-bold ">
            19.000 Orang
        </div>
        <div class="text-center text-sm">
            D4
        </div>
    </div> --}}
</div>
