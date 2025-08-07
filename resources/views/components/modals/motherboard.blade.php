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
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($moboSpecs['brands'] as $brand)
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
                    @foreach ($moboSpecs['socketTypes'] as $socketType)
                        <option value="{{ $socketType->socket_type }}">{{ $socketType->socket_type }}</option>
                    @endforeach
                </select>             
            </div>

            <div>
                <label for="">Chipset</label>
                <select required name="chipset" id="chipset">
                    <option disabled selected hidden value="">Select a chipset</option>
                    @foreach ($moboSpecs['chipsets'] as $chipset)
                        <option value="{{ $chipset->chipset }}">{{ $chipset->chipset }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col">
                <div>
                    <label for="">Form Factor</label>
                    <select required name="form_factor" id="form_factor">
                        <option disabled selected hidden value="">Select a formFactor</option>
                        <option value="Micro-ATX">Micro-ATX</option>
                        <option value="ATX">ATX</option>
                        <option value="Mini-ITX">Mini-ITX</option>
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
                <select required name="ram_type" id="ram_type">
                    <option disabled selected hidden value="">Select a ram type</option>   
                    @foreach ($moboSpecs['ramTypes'] as $ramType)
                        <option value="{{ $ramType->ram_type}}">{{ $ramType->ram_type }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Max Ram</label>
                <select required name="max_ram" id="max_ram">
                    <option disabled selected hidden value="">Select a max ram</option>   
                    @foreach ($moboSpecs['maxRams'] as $maxRam)
                        <option value="{{ $maxRam->max_ram}}">{{ $maxRam->max_ram }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Ram Slots</label>
                <select required name="ram_slots" id="ram_slots">
                    <option disabled selected hidden value="">Select a ram slots</option>   
                    @foreach ($moboSpecs['ramSlots'] as $ramSlot)
                        <option value="{{ $ramSlot->ram_slots }}">{{ $ramSlot->ram_slots }}</option>
                    @endforeach 
                </select> 
            </div>
            
            <div>
                <label for="">Max Ram Speed</label>
                <input required name="max_ram_speed" id="max_ram_speed" required type="text" placeholder="Enter max RAM speed">
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col">
                        <div>
                            <label for="">PCIe Slots <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select required :name="'pcie_slots[' + index + '][version]'" id="version">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($moboSpecs['versions'] as $version)
                                        <option value={{ $version->version}}>{{ $version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'pcie_slots[' + index + '][lane_type]'" id="laneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($moboSpecs['laneTypes'] as $laneType)
                                        <option value={{ $laneType->lane_type}}>{{ $laneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'pcie_slots[' + index + '][quantity]'" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($moboSpecs['quantities'] as $quantity)
                                        <option value={{ $quantity->quantity}}>{{ $quantity->quantity }}</option>
                                    @endforeach 
                                </select>   
                            </div>    
                        </div>
                        <div class="nested">
                            <div class="flex flex-col">
                                {{-- <label for="notes">Notes</label> --}}
                                <input :name="'pcie_slots[' + index + '][add_notes]'" type="text" placeholder="Enter additional description">
                            </div>  
                        </div>    
                        
                        <template x-if="index > 0">
                            <button type="button"
                                class="remove-add"
                                @click="slots.splice(index, 1)">
                                x
                            </button>    
                        </template>
                    </div>
                </template>
                
                {{-- ADD PCIE BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add PCIe Slot
                </button>
                
            </div>

            <div class="flex flex-col mb-3"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col mb-3">
                        <div>
                            <label for="">M2 Slots <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select required :name="'m2_slots[' + index + '][length]'" id="length">
                                <option disabled selected hidden value="">Length</option>   
                                @foreach ($moboSpecs['lengths'] as $length)
                                    <option value={{ $length->length}}>{{ $length->length }}</option>
                                @endforeach 
                                </select> 
                                <select required :name="'m2_slots[' + index + '][version]'" id="m2Version">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($moboSpecs['m2Versions'] as $m2Version)
                                        <option value={{ $m2Version->version}}>{{ $m2Version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'m2_slots[' + index + '][lane_type]'" id="m2LaneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($moboSpecs['m2LaneTypes'] as $m2LaneType)
                                        <option value={{ $m2LaneType->lane_type}}>{{ $m2LaneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'m2_slots[' + index + '][quantity]'" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($moboSpecs['quantities'] as $quantity)
                                        <option value={{ $quantity->quantity}}>{{ $quantity->quantity }}</option>
                                    @endforeach 
                                </select>    
                            </div>    
                        </div>
                        <div class="checkbox-input">
                            <input :name="'m2_slots[' + index + '][supports_sata]'" type="hidden" value="false">
                            <input :name="'m2_slots[' + index + '][supports_sata]'" type="checkbox" value="true">
                            <label for="">Supports Sata</label>
                        </div> 

                        <template x-if="index > 0">
                            <button type="button"
                                class="remove-add bottom"
                                @click="slots.splice(index, 1)">
                                x
                            </button>    
                        </template>
                    </div>
                </template>
                      
                {{-- ADD M2 BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie top">
                    + Add M2 Slot
                </button> 
            </div>

            <div>
                <label for="">Sata Port</label>
                <div class="w-[80%]">
                    <select required name="version" id="sataVersion">
                        <option disabled selected hidden value="">Version</option>   
                        @foreach ($moboSpecs['sataVersions'] as $sataVersion)
                            <option value="{{ $sataVersion->version}}">{{ $sataVersion->version }}</option>
                        @endforeach 
                    </select> 
                    <select required name="quantity" id="sataQuantity">
                        <option disabled selected hidden value="">Quantity</option>   
                        @foreach ($moboSpecs['sataQuantities'] as $sataQuantity)
                            <option value="{{ $sataQuantity->quantity}}">{{ $sataQuantity->quantity }}</option>
                        @endforeach 
                    </select>   
                </div>    
            </div>

            <div class="flex flex-col "
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col mb-2">
                        <div>
                            <label for="">USB Port <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select required :name="'usb_ports[' + index + '][version]'" id="usbVersion">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($moboSpecs['usbVersions'] as $usbVersion)
                                        <option value={{ $usbVersion->version}}>{{ $usbVersion->version }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'usb_ports[' + index + '][location]'" id="location">
                                    <option disabled selected hidden value="">Location</option>   
                                    @foreach ($moboSpecs['locations'] as $location)
                                        <option value={{ $location->location}}>{{ $location->location }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'usb_ports[' + index + '][type]'" id="type">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($moboSpecs['types'] as $type)
                                        <option value={{ $type->type }}>{{ $type->type  }}</option>
                                    @endforeach 
                                </select> 
                                <select required :name="'usb_ports[' + index + '][quantity]'" id="usbQuantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($moboSpecs['usbQuantities'] as $usbQuantity)
                                        <option value={{ $usbQuantity->quantity}}>{{ $usbQuantity->quantity }}</option>
                                    @endforeach 
                                </select>    
                            </div>    
                        </div>
                        <template x-if="index > 0">
                            <button type="button"
                                class="remove-add usb"
                                @click="slots.splice(index, 1)">
                                x
                            </button>    
                        </template>
                    </div>
                </template>
                      
                {{-- ADD M2 BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie bottom">
                    + Add USB Slot
                </button> 
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
                    @foreach ($moboSpecs['buildCategories'] as $buildCategory)
                        <option value="{{ $buildCategory->id }}">{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input name="stock" id="stock" type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="product-img">Upload product image</label>    
                
                <div class="product-img">
                    <input type="file" id="image" name="image" accept="image/*" class="custom-file" onchange="updateFileName(this)">

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
