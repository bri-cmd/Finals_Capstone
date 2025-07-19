<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Motherboard</h2>
</div>

<form action="" class="new-component-form">
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <input type="text">
            </div>

            <div>
                <label for="">Models</label>
                <input type="text">
            </div>

            <div>
                <label for="">Socket Type</label>
                <input type="text">
            </div>

            <div>
                <label for="">Chipset</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Form Facto</label>
                <input type="text">
            </div>

            <div>
                <label for="">Ram Type</label>
                <input type="text">
            </div>

            <div>
                <label for="">Max Ram</label>
                <input type="text">
            </div>

            <div>
                <label for="">Ram Slots</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Max Ram Speed</label>
                <input type="text">
            </div>

            <div>
                <label for="">PCIe Slots</label>
                <input type="text">
            </div>

            <div>
                <label for="">M2 Slots</label>
                <input type="text">
            </div>

            <div>
                <label for="">Sata Ports</label>
                <input type="text">
            </div>

            <div>
                <label for="">USB Ports</label>
                <input type="text">
            </div>

            <div>
                <label for="">Wifi OnBoard</label>
                <input type="text">
            </div>

        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <input type="text">
            </div>

            <div>
                <label for="">Stock</label>
                <input type="text">
            </div>

            <div>
                <label for="">Upload Image</label>
                <input type="text">
            </div>

            <div>
                <label for="">Upload 3d Model</label>
                <input type="text">
            </div>
        </div>    
    </div>
    
    <button>Add Component</button>
</form>