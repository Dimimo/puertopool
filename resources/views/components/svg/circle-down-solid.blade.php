@props(['color' => 'fill-white', 'size' => 5, 'padding' => 'mb-1'])
<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 512 512"
    {{ $attributes->merge(['class' => 'inline-block w-'.$size.' h-'.$size.' '.$color.' '.$padding]) }}
>
    <path
        d="M256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM244.7 395.3l-112-112c-4.6-4.6-5.9-11.5-3.5-17.4s8.3-9.9 14.8-9.9l64 0 0-96c0-17.7 14.3-32 32-32l32 0c17.7 0 32 14.3 32 32l0 96 64 0c6.5 0 12.3 3.9 14.8 9.9s1.1 12.9-3.5 17.4l-112 112c-6.2 6.2-16.4 6.2-22.6 0z"/>
</svg>