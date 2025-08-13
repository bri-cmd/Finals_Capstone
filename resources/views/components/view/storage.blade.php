{{-- <pre x-text="JSON.stringify(selectedComponent, null, 2)"></pre> --}}
<h2 class="text-center !relative">View</h2>
<div class="view-container">
    {{-- IMAGE --}}
    <div class="image-container">
        <img :src="`/${selectedComponent.image}`" alt="Product Image" >
    </div>
    {{-- SPECS --}}
    <div class="specs-container">
        <div>
            <p>Brand</p>
            <p x-text="selectedComponent.brand"></p>
        </div>
        <div>
            <p>Model</p>
            <p x-text="selectedComponent.model"></p>
        </div>
        <div>
            <p>Storage Type</p>
            <p x-text="selectedComponent.storage_type"></p>
        </div>
        <div>
            <p>Interface</p>
            <p x-text="selectedComponent.interface"></p>
        </div>
        <div>
            <p>Capacity</p>
            <p x-text="selectedComponent.capacity_display"></p>
        </div>
        <div>
            <p>Form Factor</p>
            <p x-text="selectedComponent.form_factor"></p>
        </div>
        <div>
            <p>Read Speed</p>
            <p x-text="selectedComponent.read_display"></p>
        </div>
        <div>
            <p>Write Speed</p>
            <p x-text="selectedComponent.write_display"></p>
        </div>
        <div>
            <p>Price </p>
            <p x-text="selectedComponent.price_display"></p>
        </div>
        <div>
            <p>Stock </p>
            <p x-text="selectedComponent.stock"></p>
        </div>
    </div>
</div>