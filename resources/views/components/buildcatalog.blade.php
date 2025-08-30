@props(['component'])

<div class="build-catalog" 
     data-type="{{ $component->component_type }}"
     data-image="{{ asset('storage/' . str_replace('\\', '/', $component->image)) }}"
     data-model="{{ isset($component->model_3d) ? asset('storage/' . $component->model_3d) : '' }}">
    <img src="{{ asset('storage/' . str_replace('\\', '/', $component->image)) }}" alt="{{ $component->label }}">
    <div>
        <p>{{ $component->label }}</p>
        <p>number of buyers</p>
        <p>{{ $component->price_display ?? ('₱' . number_format($component->price, 2)) }}</p>   
    </div>
    <button>Shop</button>
</div>