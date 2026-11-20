@php
    $locale = app()->getLocale();
@endphp
{{ $proxy['name'][$locale] ?? "" }}