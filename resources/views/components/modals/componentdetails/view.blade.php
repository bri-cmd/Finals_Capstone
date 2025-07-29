{{-- <pre x-text="JSON.stringify(selectedComponent, null, 2)"></pre> --}}
<h2 class="text-center !relative">View</h2>
<div class="view-container">
    {{-- IMAGE --}}
    <div class="image-container">
        <img src="https://dlcdnwebimgs.asus.com/gain/58304d96-dc0e-4367-988b-7c1b2744f147/w692" alt="">
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
            <p>Socket Type</p>
            <p x-text="selectedComponent.socket_type"></p>
        </div>
        <div>
            <p>Chipset</p>
            <p x-text="selectedComponent.chipset"></p>
        </div>
        <div>
            <p>Form Factor </p>
            <p x-text="selectedComponent.form_factor"></p>
        </div>
        <div>
            <p>RAM Type</p>
            <p x-text="selectedComponent.ram_type"></p>
        </div>
        <div>
            <p>Max RAM</p>
            <p x-text="selectedComponent.max_ram + ' GB'"></p>
        </div>
        <div>
            <p>Max RAM Speed</p>
            <p x-text="selectedComponent.max_ram_speed"></p>
        </div>
        <div>
            <p>PCIe Slots </p>
            <p x-html="selectedComponent.pcie_display"></p>
        </div>
        <div>
            <p>M.2 Slots </p>
            <p x-html="selectedComponent.m2_display"></p>
        </div>
        <div>
            <p>SATA Ports </p>
            <p x-html="selectedComponent.sata_display"></p>
        </div>
        <div>
            <p>USB Ports </p>
            <p x-html="selectedComponent.usb_display"></p>
        </div>
        <div>
            <p>Wi-Fi Onboard </p>
            <p x-text="selectedComponent.wifi_onboard ? selectedComponent.wifi_onboard : 'No'"></p>

        </div>
        <div>
            <p>Price </p>
            <p x-text="selectedComponent.price"></p>
        </div>
        <div>
            <p>Stock </p>
            <p x-text="selectedComponent.stock"></p>
        </div>
    </div>
</div>