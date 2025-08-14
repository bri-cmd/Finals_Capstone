@props(['moboSpecs'])
{{-- <pre>{{ json_encode($ram_type) }}</pre> --}}
<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Motherboard</h2>
</div>

<form action="{{ route('staff.componentdetails.motherboard.store') }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($moboSpecs['brands'] as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="">Model</label>
                <input name="model" type="text" placeholder="Enter model" required>
            </div>
            <div>
                <label for="">Socket Types</label>
                <select name="socket_type" id="socket_type">
                    <option disabled selected hidden value="">Select a socket type</option>
                    @foreach ($moboSpecs['socket_types'] as $socket_type)
                        <option value="{{ $socket_type }}">{{ $socket_type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="">Chipset</label>
                <select name="chipset" id="chipset">
                    <option disabled selected hidden value="">Select a chipset</option>
                    @foreach ($moboSpecs['chipsets'] as $chipset)
                        <option value="{{ $chipset }}">{{ $chipset }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="">Form Factor</label>
                <select name="form_factor" id="form_factor">
                    <option disabled selected hidden value="">Select a form factor</option>
                    @foreach ($moboSpecs['form_factors'] as $form_factor)
                        <option value="{{ $form_factor }}">{{ $form_factor }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="">RAM Type</label>
                <select name="ram_type" id="ram_type">
                    <option disabled selected hidden value="">Select a ram type</option>
                    @foreach ($moboSpecs['ram_types'] as $ram_type)
                        <option value="{{ $ram_type }}">{{ $ram_type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="">Max RAM</label>
                <input required name="max_ram" id="max_ram" type="number" placeholder="00 GB" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">RAM Slots</label>
                <input required name="ram_slots" id="ram_slots" type="number" placeholder="No. of ram slots" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">Max RAM Speed</label>
                <input required name="max_ram_speed" id="max_ram_speed" type="number" placeholder="000 MHz" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">PCIe Slots</label>
                <input required name="pcie_slots" id="pcie_slots" type="number" placeholder="No. of pcie slots" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">M2 Slots</label>
                <input required name="m2_slots" id="m2_slots" type="number" placeholder="No. of m2 slots" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">Sata Ports</label>
                <input required name="sata_ports" id="sata_ports" type="number" placeholder="No. of sata ports" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">USB Ports</label>
                <input required name="usb_ports" id="usb_ports" type="number" placeholder="No. of usb ports" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div>
                <label for="">Wi-Fi onboard</label>
                <select name="wifi_onboard" id="wifi_onboard">
                    <option disabled selected hidden value="">Has Wi-Fi onboard</option>
                    @foreach ($moboSpecs['wifi_onboards'] as $wifi_onboard)
                        <option value="{{ $wifi_onboard }}">{{ $wifi_onboard }}</option>
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
                    @foreach ($moboSpecs['buildCategories'] as $buildCategory)
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
