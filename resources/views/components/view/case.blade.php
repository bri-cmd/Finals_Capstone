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
            <p>Form Factor Support</p>
            <p x-html="selectedComponent.form_display"></p>
        </div>
        <div>
            <p>Max GPU Lenght</p>
            <p x-text="selectedComponent.max_gpu_length_display"></p>
        </div>
        <div>
            <p>Max Cooler Height</p>
            <p x-text="selectedComponent.max_cooler_height_display"></p>
        </div>
        <div>
            <p>Radiator Support</p>
            <p x-html="selectedComponent.radiator_display"></p>
        </div>
        <div>
            <p>Drive Bays</p>
            <p x-html="selectedComponent.drive_display"></p>
        </div>
        <div>
            <p>Fan Mounts</p>
            <p x-html="selectedComponent.fan_display"></p>
        </div>
        <div>
            <p>Front USB Ports</p>
            <p x-html="selectedComponent.usb_display"></p>
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