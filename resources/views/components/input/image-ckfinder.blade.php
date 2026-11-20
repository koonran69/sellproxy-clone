<input type="text" {{ $attributes->class(['d-none']) }} name="{{ $name }}" value="{{ $value }}">
<img id="{{ $showImage }}" 
    class="add-image-ckfinder pointer" 
    data-preview="#{{ $showImage }}"
    data-input="input[name='{{ $name }}']" 
    data-type="" 
    src="{{asset($value)}}" 
    style="width: 100%; height: 100%; object-fit: cover;" >