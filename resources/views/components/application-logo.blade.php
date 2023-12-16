@props(['imgclass' => ''])

<img {{ $attributes->merge(['class' => 'card-body ' .$imgclass]) }} src="{{asset('logo.png')}}" alt="">
