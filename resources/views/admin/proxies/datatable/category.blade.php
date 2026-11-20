@if ($category)
    {{ $category['name'][app()->getLocale()] }}
@endif