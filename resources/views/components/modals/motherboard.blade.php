@props(['specs'])
{{-- <pre>{{ json_encode($ram_type) }}</pre> --}}
<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Motherboard</h2>
</div>

<form action="{{ route('staff.componentdetails.store', ['type' => 'motherboard']) }}" method="POST" class="new-component-form">
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
                <input required type="text" placeholder="Enter Model">
            </div>

            <div>
                <label for="">Socket Type</label>
                <select required name="socketType" id="socketType">
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
                        <option value={{ $chipset->chipset }}>{{ $chipset->chipset }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col">
                <div>
                    <label for="">Form Factor</label>
                    <select required name="formFactor" id="formFactor">
                    <option disabled selected hidden value="">Select a formFactor</option>
                    @foreach ($specs['formFactors'] as $formFactor)
                        <option value={{ $formFactor->form_factor }}>{{ $formFactor->form_factor }}</option>
                    @endforeach
                </select>
                </div>
                

                {{-- MEASUREMENTS --}}
                <div class="nested">
                    <div>
                        <input type="number" placeholder="Width 000cm" onkeydown="return !['e','E','+','-'].includes(event.key)">
                        <input type="number" placeholder="Height 000cm" onkeydown="return !['e','E','+','-'].includes(event.key)">
                    </div>    
                </div>
            </div>

            <div>
                <label for="">Ram Type</label>
                <select name="ramType" id="ramType">
                    <option disabled selected hidden value="">Select a ram type</option>   
                    @foreach ($specs['ramTypes'] as $ramType)
                        <option value={{ $ramType->ram_type}}>{{ $ramType->ram_type }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Max Ram</label>
                <select name="maxRam" id="maxRam">
                    <option disabled selected hidden value="">Select a max ram</option>   
                    @foreach ($specs['maxRams'] as $maxRam)
                        <option value={{ $maxRam->max_ram}}>{{ $maxRam->max_ram }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Ram Slots</label>
                <select name="ramSlot" id="ramSlot">
                    <option disabled selected hidden value="">Select a ram slots</option>   
                    @foreach ($specs['ramSlots'] as $ramSlot)
                        <option value={{ $ramSlot->ram_slots}}>{{ $ramSlot->ram_slots }}</option>
                    @endforeach 
                </select> 
            </div>
            
            <div>
                <label for="">Max Ram Speed</label>
                <input required type="text" placeholder="Enter max RAM speed">
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col">
                        <div>
                            <label for="">PCIe Slots <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select name="version" id="version">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($specs['versions'] as $version)
                                        <option value={{ $version->version}}>{{ $version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="laneType" id="laneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($specs['laneTypes'] as $laneType)
                                        <option value={{ $laneType->lane_type}}>{{ $laneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select name="quantity" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($specs['quantities'] as $quantity)
                                        <option value={{ $quantity->quantity}}>{{ $quantity->quantity }}</option>
                                    @endforeach 
                                </select>   
                            </div>    
                        </div>
                        <div class="nested">
                            <div class="flex flex-col">
                                {{-- <label for="notes">Notes</label> --}}
                                <input type="text" placeholder="Enter additional description">
                            </div>  
                        </div>      
                    </div>
                </template>
                      
                
                {{-- ADD PCIE BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add PCIe Slot
                </button>
            </div>

            <div class="flex flex-col "
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col mb-3">
                        <div>
                            <label for="">M2 Slots <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select name="length" id="length">
                                <option disabled selected hidden value="">Length</option>   
                                @foreach ($specs['lengths'] as $length)
                                    <option value={{ $length->length}}>{{ $length->length }}</option>
                                @endforeach 
                                </select> 
                                <select name="m2Version" id="m2Version">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($specs['m2Versions'] as $m2Version)
                                        <option value={{ $m2Version->version}}>{{ $m2Version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="m2LaneType" id="m2LaneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($specs['m2LaneTypes'] as $m2LaneType)
                                        <option value={{ $m2LaneType->lane_type}}>{{ $m2LaneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select name="quantity" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($specs['quantities'] as $quantity)
                                        <option value={{ $quantity->quantity}}>{{ $quantity->quantity }}</option>
                                    @endforeach 
                                </select>    
                            </div>    
                        </div>
                        <div class="checkbox-input">
                        <label for="">Supports Sata</label>
                        <input type="checkbox">
                    </div> 
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
                <label for="">Sata Port <span x-text="index + 1"></span></label>
                <div class="w-[80%]">
                    <select name="sataVersion" id="sataVersion">
                        <option disabled selected hidden value="">Version</option>   
                        @foreach ($specs['sataVersions'] as $sataVersion)
                            <option value={{ $sataVersion->version}}>{{ $sataVersion->version }}</option>
                        @endforeach 
                    </select> 
                    <select name="sataQuantity" id="sataQuantity">
                        <option disabled selected hidden value="">Quantity</option>   
                        @foreach ($specs['sataQuantities'] as $sataQuantity)
                            <option value={{ $sataQuantity->quantity}}>{{ $sataQuantity->quantity }}</option>
                        @endforeach 
                    </select>   
                </div>    
            </div>

            <div class="flex flex-col "
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div class="flex flex-col mb-3">
                        <div>
                            <label for="">USB Port <span x-text="index + 1"></span></label>
                            <div class="w-[80%]">
                                <select name="usbVersion" id="usbVersion">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($specs['usbVersions'] as $usbVersion)
                                        <option value={{ $usbVersion->version}}>{{ $usbVersion->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="location" id="location">
                                    <option disabled selected hidden value="">Location</option>   
                                    @foreach ($specs['locations'] as $location)
                                        <option value={{ $location->location}}>{{ $location->location }}</option>
                                    @endforeach 
                                </select> 
                                <select name="type" id="type">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($specs['types'] as $type)
                                        <option value={{ $type->type }}>{{ $type->type  }}</option>
                                    @endforeach 
                                </select> 
                                <select name="usbQuantity" id="usbQuantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($specs['usbQuantities'] as $usbQuantity)
                                        <option value={{ $usbQuantity->quantity}}>{{ $usbQuantity->quantity }}</option>
                                    @endforeach 
                                </select>    
                            </div>    
                        </div>
                    </div>
                    
                </template>
                      
                {{-- ADD M2 BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie top">
                    + Add USB Slot
                </button> 
            </div>

            <div>
                <label for="">Wifi OnBoard</label>
                <input required type="text" placeholder="Enter details if applicable">
            </div>

        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input type="number" step="0.01" placeholder="Enter price" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <select name="buildCategory" id="buildCategory">
                    <option disabled selected hidden value="">Select build category</option>   
                    @foreach ($specs['buildCategories'] as $buildCategory)
                        <option value={{ $buildCategory->name }}>{{ $buildCategory->name }}</option>
                    @endforeach 
                </select>  
            </div>

            <div>
                <label for="">Stock</label>
                <input type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div class="prod">
                <label for="product_img">Upload product image</label>    
                
                <div class="product-img">
                    <input type="file" id="product_img" name="product_img" accept="image/*" class="custom-file" onchange="updateFileName(this)">

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
                    <input type="file" id="product_3d" name="product_3d" accept="image/*" class="custom-file" onchange="updateFileName(this)">

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
            const fileNameDisplay = document.getElementById('filename');
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
