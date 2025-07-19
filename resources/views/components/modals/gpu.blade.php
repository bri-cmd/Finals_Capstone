<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">GPU</h2>
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
                <label for="">Video RAM GB</label>
                <input type="text">
            </div>

            <div>
                <label for="">Power Draw Watts</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Recommended PSU Watt</label>
                <input type="text">
            </div>

            <div>
                <label for="">Lenght MM</label>
                <input type="text">
            </div>

            <div>
                <label for="">PCIe Interface</label>
                <input type="text">
            </div>

            <div>
                <label for="">Connectors Required</label>
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