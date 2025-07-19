<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Case</h2>
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
                <label for="">Form Factor Support</label>
                <input type="text">
            </div>

            <div>
                <label for="">Max GPU Lenght mm</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Max Cooler Height mm</label>
                <input type="text">
            </div>

            <div>
                <label for="">Radiator Support</label>
                <input type="text">
            </div>

            <div>
                <label for="">Drive Bays</label>
                <input type="text">
            </div>

            <div>
                <label for="">Fan Mounts</label>
                <input type="text">
            </div>

            <div>
                <label for="">Front USB Ports</label>
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