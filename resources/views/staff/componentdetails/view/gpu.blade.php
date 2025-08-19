{{-- <pre x-text="JSON.stringify(selectedComponent, null, 2)"></pre> --}}
<h2 class="text-center !relative">View</h2>
<div class="view-container" x-data="{ modelId: 'modelCanvas-gpu' }">
    {{-- IMAGE --}}
    <div class="image-container" x-show="selectedComponent.image && selectedComponent.image.length">
        <template x-for="fileId in selectedComponent.image">
            <img :src="`https://drive.google.com/thumbnail?id=${fileId}`" class="image-container">
        </template>

        <div 
            x-init="
                $watch('selectedComponent', value => {
                    if (document.getElementById(modelId)) {
                        loadModel(modelId, value.model_3d);
                    }
                })
            ">
            <canvas :id="modelId" width="400" height="400"></canvas>
        </div>
    </div>

    <div x-show="!selectedComponent.image || selectedComponent.image.length === 0">
        <p>No image uploaded.</p>
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
            <p>VRAM GB</p>
            <p x-text="selectedComponent.vram_gb + ' GB'"></p>
        </div>
        <div>
            <p>Power Draw Watts</p>
            <p x-text="selectedComponent.power_draw_watts + ' W'"></p>
        </div>
        <div>
            <p>Recommended PSU Watt</p>
            <p x-text="selectedComponent.recommended_psu_watt + ' W'"></p>
        </div>
        <div>
            <p>Lenght</p>
            <p x-text="selectedComponent.length_mm + ' mm'"></p>
        </div>
        <div>
            <p>PCIe Interface</p>
            <p x-text="selectedComponent.pcie_interface"></p>
        </div>
        <div>
            <p>Connectors Required</p>
            <p x-text="selectedComponent.connectors_required"></p>
        </div>
        
    {{-- INVENTORY --}}
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