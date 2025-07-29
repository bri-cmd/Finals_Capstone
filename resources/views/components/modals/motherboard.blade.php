@props(['specs'])
{{-- <pre>{{ json_encode($ram_type) }}</pre> --}}
<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Motherboard</h2>
</div>

<form action="{{ route('staff.componentdetails.store', ['type' => 'motherboard']) }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($specs['brands'] as $brand)
                        <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Model</label>
                <input name="model" required type="text" placeholder="Enter Model">
            </div>

            <div>
                <label for="">Socket Type</label>
                <select required name="socket_type" id="socket_type">
                    <option disabled selected hidden value="">Select a socket type</option>
                    @foreach ($specs['socketTypes'] as $socketType)
                        <option value="{{ $socketType->socket_type }}">{{ $socketType->socket_type }}</option>
                    @endforeach
                </select>             
            </div>

            <div>
                <label for="">Chipset</label>
                <select required name="chipset" id="chipset">
                    <option disabled selected hidden value="">Select a chipset</option>
                    @foreach ($specs['chipsets'] as $chipset)
                        <option value="{{ $chipset->chipset }}">{{ $chipset->chipset }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col">
                <div>
                    <label for="">Form Factor</label>
                    <select required name="form_factor" id="form_factor">
                    <option disabled selected hidden value="">Select a formFactor</option>
                    @foreach ($specs['formFactors'] as $formFactor)
                        <option value="{{ $formFactor->form_factor }}">{{ $formFactor->form_factor }}</option>
                    @endforeach
                </select>
                </div>
                

                {{-- MEASUREMENTS --}}
                <div class="nested">
                    <div>
                        <input name="width" id="width" type="number" placeholder="Width 000cm" onkeydown="return !['e','E','+','-'].includes(event.key)">
                        <input name="height" id="height" type="number" placeholder="Height 000cm" onkeydown="return !['e','E','+','-'].includes(event.key)">
                    </div>    
                </div>
            </div>

            <div>
                <label for="">Ram Type</label>
                <select name="ram_type" id="ram_type">
                    <option disabled selected hidden value="">Select a ram type</option>   
                    @foreach ($specs['ramTypes'] as $ramType)
                        <option value="{{ $ramType->ram_type}}">{{ $ramType->ram_type }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Max Ram</label>
                <select name="max_ram" id="max_ram">
                    <option disabled selected hidden value="">Select a max ram</option>   
                    @foreach ($specs['maxRams'] as $maxRam)
                        <option value="{{ $maxRam->max_ram}}">{{ $maxRam->max_ram }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Ram Slots</label>
                <select name="ram_slots" id="ram_slots">
                    <option disabled selected hidden value="">Select a ram slots</option>   
                    @foreach ($specs['ramSlots'] as $ramSlot)
                        <option value="{{ $ramSlot->ram_slots }}">{{ $ramSlot->ram_slots }}</option>
                    @endforeach 
                </select> 
            </div>
            
            <div>
                <label for="">Max Ram Speed</label>
                <input name="max_ram_speed" id="max_ram_speed" required type="text" placeholder="Enter max RAM speed">
            </div>

            

            <div>
                <label for="">Wifi OnBoard</label>
                <input name="wifi_onboard" id="wifi_onboard" type="text" placeholder="Enter details if applicable">
            </div>

        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input name="price" id="price" type="number" step="0.01" placeholder="Enter price" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <select name="build_category_id" id="build_category_id">
                    <option disabled selected hidden value="">Select build category</option>   
                    @foreach ($specs['buildCategories'] as $buildCategory)
                        <option value="{{ $buildCategory->id }}">{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input name="stock" id="stock" type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div class="prod">
                <label for="product_img">Upload product image</label>    
                
                <div class="product-img">
                    <input type="file" id="image" name="image" accept="image/*" class="custom-file" onchange="updateFileName(this)">

                    {{-- upload icon --}}
                    <label for="product_img">
                        <x-icons.upload class="w-[16px] h-[16px]"/>    
                    </label>

                    {{-- show the file name --}}
                    <p id="filename" class="filename text-gray-500">Upload product image</p>
                </div>
            </div>

            <div class="prod">
                <label for="product_img">Upload product 3d model</label>    
                
                <div class="product-img">
                    <input type="file" id="model_3d" name="model_3d" accept=".obj,.fbx,.glb,.gltf,.stl,.dae,.3ds" class="custom-file" onchange="updateFileName(this)">

                    {{-- upload icon --}}
                    <label for="product_img">
                        <x-icons.upload class="w-[16px] h-[16px]"/>    
                    </label>

                    {{-- show the file name --}}
                    <p id="filename" class="filename text-gray-500">Upload product image</p>
                </div>
            </div>
        </div>    
    </div>
    
    <button>Add Component</button>

</form>

{{-- showing the name of the uploaded file --}}
    <script>
        function updateFileName(input) {
            // GET THE SIBLING .FILENAME ELEMENT INSIDE THE SAME .PRODUCT-IMG CONTAINER
            const container = input.closest('.product-img');
            const fileNameDisplay = container.querySelector('.filename');
            const file = input.files[0];

            if (file) {
                fileNameDisplay.textContent = file.name;
                fileNameDisplay.classList.remove("text-gray-500");
            } else {
                fileNameDisplay.textContent = 'Upload product image';
                fileNameDisplay.classList.add("text-gray-500");
            }
        }
    </script>
