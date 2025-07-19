<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">RAM</h2>
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
                <label for="">RAM Type</label>
                <input type="text">
            </div>

            <div>
                <label for="">Speed Mhz</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Size Per Module GB</label>
                <input type="text">
            </div>

            <div>
                <label for="">Total Capacity GB</label>
                <input type="text">
            </div>

            <div>
                <label for="">Module Count</label>
                <input type="text">
            </div>

            <div>
                <label for="">ECC Support</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">RGB Support</label>
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