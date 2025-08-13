@props(['ramSpecs'])

<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">RAM</h2>
</div>

<form action="{{ route('staff.componentdetails.ram.store') }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($ramSpecs['brands'] as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Models</label>
                <input name="model" required type="text" placeholder="Enter Model">
            </div>

            <div>
                <label for="">RAM Type</label>
                <select required name="ram_type" id="ram_type">
                    <option disabled selected hidden value="">Select a ram</option>
                    @foreach ($ramSpecs['rams'] as $ram)
                        <option value="{{ $ram }}">{{ $ram }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Speed Mhz</label>
                <input required name="speed_mhz" id="speed_mhz" type="number" placeholder="0000 MHz" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Size Per Module GB</label>
                <input required name="size_per_module_gb" id="size_per_module_gb" type="number" placeholder="00 GB" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Total Capacity GB</label>
                <input required name="total_capacity_gb" id="total_capacity_gb" type="number" placeholder="00 GB" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Module Count</label>
                <input required name="module_count" id="module_count" type="number" placeholder="00" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">ECC Support</label>
                <select required name="is_ecc" id="is_ecc">
                    <option disabled selected hidden value="">Select option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No (Non-ECC)</option>
                </select>
            </div>
            
            <div>
                <label for="">RGB Support</label>
                <div class="w-[80%]">
                    <select required name="is_rgb" id="is_rgb">
                        <option disabled selected hidden value="">Select option</option>
                        <option value="Yes">Yes</option>
                        <option value="">No</option>
                    </select>
                    <input name="notes" type="text" placeholder="Notes">    
                </div>
                
            </div>

        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input required name="price" id="price" type="number" step="0.01" placeholder="Enter price" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <select required name="build_category_id" id="build_category_id">
                    <option disabled selected hidden value="">Select build category</option>   
                    @foreach ($ramSpecs['buildCategories'] as $buildCategory)
                        <option value="{{ $buildCategory->id }}">{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input required name="stock" id="stock" type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="product-img">Upload product image</label>    
                
                <div class="product-img">
                    <input required type="file" id="image" name="image" accept="image/*" class="custom-file" onchange="updateFileName(this)">

                    {{-- upload icon --}}
                    <label for="image">
                        <x-icons.upload class="upload-product"/>    
                    </label>

                    {{-- show the file name --}}
                    <p id="filename" class="filename text-gray-500">Upload product image</p>
                </div>
            </div>

            <div>
                <label for="product_img">Upload product 3d model</label>    
                
                <div class="product-img">
                    <input type="file" id="model_3d" name="model_3d" accept=".obj,.fbx,.glb,.gltf,.stl,.dae,.3ds" class="custom-file" onchange="updateFileName(this)">

                    {{-- upload icon --}}
                    <label for="model_3d">
                        <x-icons.upload class="upload-product"/>    
                    </label>

                    {{-- show the file name --}}
                    <p id="filename" class="filename text-gray-500">Upload product image</p>
                </div>
            </div>
        </div>    
    </div>
    
    <button>Add Component</button>
</form>