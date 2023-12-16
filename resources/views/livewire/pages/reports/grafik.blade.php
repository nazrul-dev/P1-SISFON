<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
new class extends Component {
    public $props;
}; ?>
<div class="  mt-5  ">
    @isset($props)
        <img class="w-full" src="{{ $props }}" alt="">
    @endisset


