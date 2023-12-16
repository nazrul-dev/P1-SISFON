<div class="flex items-center space-x-2">

    <x-button.circle positive onclick="event.preventDefault();"
        wire:click="$dispatch('handlerPrint', { id: {{ $id }} })" icon="download" />
    {{-- <x-button.circle href="{{ route('document.'.$type.'.edit', $id) }}" wire:navigate.hover warning icon="pencil" /> --}}
    <x-button.circle href="{{ route('document.'.$type.'.show', $id) }}" wire:navigate.hover secondary icon="eye" />


</div>
