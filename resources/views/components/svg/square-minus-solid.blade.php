@props(['color' => 'fill-white', 'size' => 5, 'padding' => 'mb-1'])
<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 448 512"
    {{ $attributes->merge(['class' => 'inline-block w-'.$size.' h-'.$size.' '.$color.' '.$padding]) }}
>
    <path
        d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm88 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/>
</svg>
