<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Storage</h2>
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
                <label for="">Storage Type</label>
                <input type="text">
            </div>

            <div>
                <label for="">Interface</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Capacity GB</label>
                <input type="text">
            </div>

            <div>
                <label for="">Form Factor</label>
                <input type="text">
            </div>

            <div>
                <label for="">Read Speed Mbps</label>
                <input type="text">
            </div>

            <div>
                <label for="">Write Speed Mbps</label>
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