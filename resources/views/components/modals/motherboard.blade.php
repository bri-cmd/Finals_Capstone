@props(['brands', 
        'socketTypes', 
        'chipsets', 
        'formFactors', 
        'ramTypes', 
        'maxRams',
        'ramSlots',
        'versions', 
        'laneTypes',
        'quantities', 
        'lengths',
        'm2Versions',
        'm2LaneTypes',
        'supportSatas',
        'm2quantities',
        'sataVersions',
        'sataQuantities',
        'usbVersions',
        'locations',
        'types',
        'usbQuantities'])
{{-- <pre>{{ json_encode($ram_type) }}</pre> --}}
<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Motherboard</h2>
</div>

<form action="" class="new-component-form">
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($brands as $brand)
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
                <input type="text" placeholder="Enter a socket type">                   
            </div>

            <div>
                <label for="">Chipset</label>
                <select required name="chipset" id="chipset">
                    <option disabled selected hidden value="">Select a chipset</option>
                    @foreach ($chipsets as $chipset)
                        <option value={{ $chipset->chipset }}>{{ $chipset->chipset }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col">
                <div>
                    <label for="">Form Factor</label>
                    <select required name="formFactor" id="formFactor">
                    <option disabled selected hidden value="">Select a formFactor</option>
                    @foreach ($formFactors as $formFactor)
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
                    @foreach ($ramTypes as $ramType)
                        <option value={{ $ramType->ram_type}}>{{ $ramType->ram_type }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Max Ram</label>
                <select name="maxRam" id="maxRam">
                    <option disabled selected hidden value="">Select a max ram</option>   
                    @foreach ($maxRams as $maxRam)
                        <option value={{ $maxRam->max_ram}}>{{ $maxRam->max_ram }}</option>
                    @endforeach 
                </select> 
            </div>

            <div>
                <label for="">Ram Slots</label>
                <select name="ramSlot" id="ramSlot">
                    <option disabled selected hidden value="">Select a ram slots</option>   
                    @foreach ($ramSlots as $ramSlot)
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
                                    @foreach ($versions as $version)
                                        <option value={{ $version->version}}>{{ $version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="laneType" id="laneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($laneTypes as $laneType)
                                        <option value={{ $laneType->lane_type}}>{{ $laneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select name="quantity" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($quantities as $quantity)
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
                                @foreach ($lengths as $length)
                                    <option value={{ $length->length}}>{{ $length->length }}</option>
                                @endforeach 
                                </select> 
                                <select name="m2Version" id="m2Version">
                                    <option disabled selected hidden value="">Version</option>   
                                    @foreach ($m2Versions as $m2Version)
                                        <option value={{ $m2Version->version}}>{{ $m2Version->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="m2LaneType" id="m2LaneType">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($m2LaneTypes as $m2LaneType)
                                        <option value={{ $m2LaneType->lane_type}}>{{ $m2LaneType->lane_type }}</option>
                                    @endforeach 
                                </select> 
                                <select name="quantity" id="quantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($quantities as $quantity)
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
                        @foreach ($sataVersions as $sataVersion)
                            <option value={{ $sataVersion->version}}>{{ $sataVersion->version }}</option>
                        @endforeach 
                    </select> 
                    <select name="sataQuantity" id="sataQuantity">
                        <option disabled selected hidden value="">Quantity</option>   
                        @foreach ($sataQuantities as $sataQuantity)
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
                                    @foreach ($usbVersions as $usbVersion)
                                        <option value={{ $usbVersion->version}}>{{ $usbVersion->version }}</option>
                                    @endforeach 
                                </select> 
                                <select name="location" id="location">
                                    <option disabled selected hidden value="">Location</option>   
                                    @foreach ($locations as $location)
                                        <option value={{ $location->location}}>{{ $location->location }}</option>
                                    @endforeach 
                                </select> 
                                <select name="type" id="type">
                                    <option disabled selected hidden value="">LaneType</option>   
                                    @foreach ($types as $type)
                                        <option value={{ $type->type }}>{{ $type->type  }}</option>
                                    @endforeach 
                                </select> 
                                <select name="usbQuantity" id="usbQuantity">
                                    <option disabled selected hidden value="">Quantity</option>   
                                    @foreach ($usbQuantities as $usbQuantity)
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
                <input required type="text" placeholder="Select category">
            </div>

            <div>
                <label for="">Stock</label>
                <input type="number" placeholder="Enter stock" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div>
                <label for="">Upload Image</label>
                <input type="text" placeholder="Upload product image">
            </div>

            <div>
                <label for="">Upload 3d Model</label>
                <input type="text" placeholder="Upload product 3d model">
            </div>
        </div>    
    </div>
    
    <button>Add Component</button>

</form>
