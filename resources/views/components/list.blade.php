@props(['value', 'title'])

<div class="flex flex-col mb-1 border-b pb-1">
    <div class="text-sm font-semibold">

        {{ $title }} :
    </div>
    <div class="flex-1">

        {{ $value }}
    </div>
</div>
