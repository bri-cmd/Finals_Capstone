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
            <p>Wattage</p>
            <p x-text="selectedComponent.wattage + ' W'"></p>
        </div>
        <div>
            <p>Efficiency Rating</p>
            <p x-text="selectedComponent.efficiency_rating"></p>
        </div>
        <div>
            <p>Modular </p>
            <p x-text="selectedComponent.modular"></p>
        </div>
        <div>
            <p>No. of PCIe Connector</p>
            <p x-text="selectedComponent.pcie_connectors"></p>
        </div>
        <div>
            <p>No. of Sata Connectors</p>
            <p x-text="selectedComponent.sata_connectors"></p>
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