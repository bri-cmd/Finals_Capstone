@props(['brands', 
        'socketTypes', 
        'chipsets', 
        'formFactors', 
        'ramTypes', 
        'maxRams',
        'ramSlots',
        'versions', 
        'laneTypes',
        'quantities', ])
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

            <div>
                <label for="">M2 Slots</label>
                <input required type="text">
            </div>

            <div>
                <label for="">Sata Ports</label>
                <input required type="text">
            </div>

            <div>
                <label for="">USB Ports</label>
                <input required type="text">
            </div>

            <div>
                <label for="">Wifi OnBoard</label>
                <input required type="text">
            </div>

        </div>

        {{-- INVENTORY --}}
        <div class="form-divider">
            <div>
                <label for="">Price</label>
                <input required type="text">
            </div>
            
            <div>
                <label for="">Build Category</label>
                <input required type="text">
            </div>

            <div>
                <label for="">Stock</label>
                <input required type="text">
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
