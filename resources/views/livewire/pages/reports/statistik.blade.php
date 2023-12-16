<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $props;
    public $type, $field;
    public $data = [];

    public function mount()
    {
        $this->data = $this->props;
    }

    function getRandomColor()
    {
        // Generate a random hex color code
        return '#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0', STR_PAD_LEFT);
    }
}; ?>

<div>
    @isset($data)
        @if ($type !== 'Usia')
            <div class="flex flex-wrap gap-2 mt-5  ">
                @foreach ($data as $v)
                    @php
                        $randomColor = $this->getRandomColor();

                    @endphp
                    <div style="background-color: {{ $randomColor }};"
                        class=" p-2 border shadow rounded-lg   inline-flex flex-col items-center justify-center">

                        <div class="text-center gap-2 flex items-center bg-white text-gray-900 rounded-lg px-4 py-1">
                            <div class="text-sm whitespace-nowrap font-semibold">
                                {{ $v[$this->field] }} </div> <x-badge dark label="   {{ $v['total'] }}" />
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-wrap gap-2 mt-5  ">
                @foreach ($data as $k => $v)
                    @php
                        $randomColor = $this->getRandomColor();

                    @endphp

                    <div style="background-color: {{ $randomColor }};"
                        class=" p-2 border shadow rounded-lg   inline-flex flex-col items-center justify-center">

                        <div class="text-center gap-2 flex items-center bg-white text-gray-900 rounded-lg px-4 py-1">
                            <div class="text-sm whitespace-nowrap font-semibold">
                                Umur {{ $k }} Tahun </div> <x-badge dark label="  {{ $v }} " />
                        </div>
                    </div>
                @endforeach
        @endif
    </div>
@endisset




</div>
