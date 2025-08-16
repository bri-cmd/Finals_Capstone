@props(['storageSpecs'])

{{-- <pre>{{ json_encode($selectedComponent->id) }}</pre> --}}

<div class="new-component-header">
    <h2 class="text-center">Storage</h2>
</div>

<form x-bind:action="'/staff/component-details/storage/' + selectedComponent.id" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    
    <input type="hidden" name="_method" value="PUT">
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand" x-model="selectedComponent.brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($storageSpecs['brands'] as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Models</label>
                <input name="model" required type="text" x-model="selectedComponent.model" placeholder="Enter Model" >
            </div>

            <div>
                <label for="">Storage Type</label>
                <select required name="storage_type" id="storage_type" x-model="selectedComponent.storage_type">
                    <option disabled selected hidden value="">Select storage type</option>
                    @foreach ($storageSpecs['storage_types'] as $storage_type)
                        <option value="{{ $storage_type }}">{{ $storage_type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Interface</label>
                <input name="interface" required type="text" x-model="selectedComponent.storage_type" placeholder="Enter interface">
            </div>
            
            <div>
                <label for="">Capacity GB</label>
                <input required name="capacity_gb" id="capacity_gb" type="number" x-model="selectedComponent.capacity_gb" placeholder="000 GB" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Form Factor</label>
                <input name="form_factor" required type="text" x-model="selectedComponent.form_factor" placeholder="Enter form factor">
            </div>

            <div>
                <label for="">Read Speed Mbps</label>
                <input required name="read_speed_mbps" id="read_speed_mbps" type="number" x-model="selectedComponent.read_speed_mbps" placeholder="000 MB/s" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Write Speed Mbps</label>
                <input required name="write_speed_mbps" id="write_speed_mbps" type="number" x-model="selectedComponent.write_speed_mbps" placeholder="000 MB/s" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input required name="price" id="price" type="number" step="0.01" x-model="selectedComponent.price" placeholder="Enter price" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <select required name="build_category_id" id="build_category_id" x-model="selectedComponent.build_category_id">
                    <option disabled selected hidden value="">Select build category</option>   
                    @foreach ($storageSpecs['buildCategories'] as $buildCategory)
                        <option value="{{ $buildCategory->id }}">{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input required name="stock" id="stock" type="number" placeholder="Enter stock" x-model="selectedComponent.stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="product-img">Upload product image</label>    
                
                <div x-data="{ filename: @js($selectedComponent->image ?? 'Upload product image') }" class="product-img">
                    <input type="file" id="image" name="image" accept="image/*"
                        class="custom-file" 
                        @change="filename = $event.target.files[0]?.name || 'Upload product image'; console.log('Filename:', filename);" />

                    <label for="image">
                        <x-icons.upload class="upload-product"/>
                    </label>

                    <p x-text="filename" :class="{ 'text-gray-500': filename === 'Upload product image' }" class="filename" ></p>
                </div>
            </div>

            <div>
                <label for="">Upload image</label>
                <input type="file">
            </div>

            <div>
                <label for="product_img">Upload product 3d model</label>    
                
                <div x-data="{ filename: 'Upload product image' }" class="product-img">
                    <input type="file" id="model_3d" name="model_3d" accept=".obj,.fbx,.glb,.gltf,.stl,.dae,.3ds"
                        class="custom-file"
                        @change="filename = $event.target.files[0]?.name || 'Upload product image'" />

                    <label for="image">
                        <x-icons.upload class="upload-product"/>
                    </label>

                    <p x-text="filename" :class="{ 'text-gray-500': filename === 'Upload product image' }" class="filename"></p>
                </div>
            </div>
        </div>      
    </div>
    
    <button>Update Component</button>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        console.log("Alpine is initialized");
    });
</script>
