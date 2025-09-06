<div class="component-button draggable" 
     data-type="{{ $attributes->get('data-type') }}" 
     data-model="{{ $attributes->get('data-model') }}"
     data-selected-id="{{ $attributes->get('data-selected-id') }}">
    <img src="" alt="">
    <p>{{ $slot }}</p>
</div>