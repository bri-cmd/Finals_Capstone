@props(['psuSpecs'])
<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">PSU</h2>
</div>

<form action="{{ route('staff.componentdetails.psu.store') }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($psuSpecs['brands'] as $brand)
                        <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                    @endforeach
                </select>
            </div>

             <div>
                <label for="">Model</label>
                <input name="model" required type="text" placeholder="Enter model">
            </div>

            <div>
                <label for="">Wattage</label>
                <input required name="wattage" id="wattage" type="number" placeholder="00 W" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Efficiency Rating</label>
                <div class="w-[80%]">
                    <select required name="efficiency_rating" id="efficiency_rating">
                        <option disabled selected hidden value="">Rating</option>
                        @foreach ($psuSpecs['ratings'] as $rating)
                            <option value="{{ $rating }}">{{ $rating }}</option>
                        @endforeach
                    </select>
                    <input name="efficiency_percent" id="efficiency_percent" type="number" placeholder="Efficiency" onkeydown="return !['e','E','+','-'].includes(event.key)">
                    <input name="notes" type="text" placeholder="Notes">    
                </div>
                
            </div>
            
            <div>
                <label for="">Modular</label>
                <select required name="modular" id="modular">
                    <option disabled selected hidden value="">Select modular</option>
                    @foreach ($psuSpecs['modulars'] as $modular)
                        <option value="{{ $modular }}">{{ $modular }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">PCIe Connectors</label>
                <select required name="pcie_connectors" id="pcie_connectors">
                    <option disabled selected hidden value="">Select pcie connector</option>
                    @foreach ($psuSpecs['pcies'] as $pcie)
                        <option value="{{ $pcie }}">{{ $pcie }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Sata Connectors</label>
                <select required name="sata_connectors" id="sata_connectors">
                    <option disabled selected hidden value="">Select sata connector</option>
                    @foreach ($psuSpecs['satas'] as $satas)
                        <option value="{{ $satas }}">{{ $satas }}</option>
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
                    @foreach ($psuSpecs['buildCategories'] as $buildCategory)
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