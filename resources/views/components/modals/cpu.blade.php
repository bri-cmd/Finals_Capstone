<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">CPU</h2>
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
                <label for="">Cores</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Threads</label>
                <input type="text">
            </div>

            <div>
                <label for="">Base Clocks</label>
                <input type="text">
            </div>

            <div>
                <label for="">Boost Clocks</label>
                <input type="text">
            </div>

            <div>
                <label for="">TDP</label>
                <input type="text">
            </div>
            
            <div>
                <label for="">Integrated Graphics</label>
                <input type="text">
            </div>

            <div>
                <label for="">Generation</label>
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