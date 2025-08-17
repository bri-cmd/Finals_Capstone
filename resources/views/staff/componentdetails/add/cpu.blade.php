@props(['cpuSpecs'])

<div class="new-component-header">
    <h2 class="text-center">CPU</h2>
</div>

<form action="{{ route('staff.componentdetails.cpu.store') }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="component_type" value="cpu">

    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($cpuSpecs['brands'] as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Models</label>
                <input name="model" required type="text" placeholder="Enter Model">
            </div>

            <div>
                <label for="">Socket Type</label>
                <select required name="socket_type" id="socket_type">
                    <option disabled selected hidden value="">Select a socket type</option>
                    @foreach ($cpuSpecs['socket_types'] as $socket_type)
                        <option value="{{ $socket_type }}">{{ $socket_type }}</option>
                    @endforeach
                </select>  
            </div>

            <div>
                <label for="">Cores</label>
                <input required name="cores" id="cores" type="number" placeholder="00" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Threads</label>
                <input required name="threads" id="threads" type="number" placeholder="00" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Base Clocks</label>
                <input required name="base_clock" id="base_clock" type="number" step="0.01" placeholder="0.00 GHz" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Boost Clocks</label>
                <input required name="boost_clock" id="boost_clock" type="number" step="0.01" placeholder="0.00 GHz" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">TDP</label>
                <input required name="tdp" id="tdp" type="number" placeholder="00 W" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Integrated Graphics</label>
                <select required name="integrated_graphics" id="integrated_graphics">
                    <option disabled selected hidden value="">Has integrated graphics</option>
                    @foreach ($cpuSpecs['integrated_displays'] as $integrated_display)
                        <option value="{{ $integrated_display }}">{{ $integrated_display }}</option>
                    @endforeach
                </select>  
            </div>

            <div>
                <label for="">Generation</label>
                <select required name="generation" id="generation">
                    <option disabled selected hidden value="">Select generation</option>
                    @foreach ($cpuSpecs['generations'] as $generation)
                        <option value="{{ $generation }}">{{ $generation }}</option>
                    @endforeach
                </select>  
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
                    @foreach ($cpuSpecs['buildCategories'] as $buildCategory)
                        <option value="{{ $buildCategory->id }}">{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input required name="stock" id="stock" type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            {{-- <div>
                <label for="product-img">Upload product image</label>    
                
                <div x-data="{ filename: 'Upload product image' }" class="product-img">
                    <input type="file" id="image" name="image" accept="image/*"
                        class="custom-file"
                        @change="filename = $event.target.files[0]?.name || 'Upload product image'" />

                    <label for="image">
                        <x-icons.upload class="upload-product"/>
                    </label>

                    <p x-text="filename" :class="{ 'text-gray-500': filename === 'Upload product image' }" class="filename"></p>
                </div>
            </div> --}}

            <div>
                <label for="">Upload product image</label>
                <input type="file" name="image[]" multiple accept="image/*">
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
    
    <button>Add Component</button>
</form>