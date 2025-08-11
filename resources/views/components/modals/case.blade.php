@props(['caseSpecs'])

<div class="new-component-header">
    {{ $slot }}

    <h2 class="text-center">Case</h2>
</div>

<form action="{{ route('staff.componentdetails.case.store') }}" method="POST" class="new-component-form" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        {{-- SPECS --}}
        <div class="form-divider">
            <div>
                <label for="">Brand</label>
                <select required name="brand" id="brand">
                    <option disabled selected hidden value="">Select a brand</option>
                    @foreach ($caseSpecs['brands'] as $brand)
                        <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Model</label>
                <input name="model" required type="text" placeholder="Enter Model">
            </div>

            <div>
                <label for="">Max GPU Lenght mm</label>
                <input required name="max_gpu_length_mm" id="max_gpu_length_mm" type="number" placeholder="Enter Max GPU Length" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            
            <div>
                <label for="">Max Cooler Height mm</label>
                <input required name="max_cooler_height_mm" id="max_cooler_height_mm" type="number" placeholder="Enter Max Cooler Height" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div >
                        <label for="">Form Factor Support <span x-text="index + 1"></span></label>
                        <select required :name="'form_factor[' + index + '][form_factor_support]'" id="form_factor_support">
                            <option disabled selected hidden value="">Select a form factor support</option>
                            @foreach ($caseSpecs['form_factor_supports'] as $form_factor_support)
                                <option value="{{ $form_factor_support->form_factor_support }}">{{ $form_factor_support->form_factor_support }}</option>
                            @endforeach
                        </select>
                        
                        <template x-if="index > 0">
                            <button type="button"
                                class="remove-add"
                                @click="slots.splice(index, 1)">
                                x
                            </button>    
                        </template>
                    </div>
                </template>
                
                {{-- ADD FORM FACTOR BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add Form Factor
                </button>
                
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div >
                        <label for="">Radiator Support <span x-text="index + 1"></span></label>
                        <div class="w-[80%]">
                            <select required :name="'radiator_support[' + index + '][location]'" id="radiatorlocation">
                                <option disabled selected hidden value="">Location</option>
                                @foreach ($caseSpecs['locations'] as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <input required :name="'radiator_support[' + index + '][size_mm]'"  id="size_mm" type="number"  placeholder="Size 00 mm" onkeydown="return !['e','E','+','-'].includes(event.key)">
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
                
                {{-- ADD RADIATOR SUPPORT BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add Radiator Support
                </button>
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div >
                        <label for="">Drive <br> Bays <span x-text="index + 1"></span></label>
                        <div class="w-[80%]">
                            <input required :name="'drive_bays[' + index + '][size_inch]'" id="size_inch" type="number" step="0.01" placeholder="Size 00 inch" onkeydown="return !['e','E','+','-'].includes(event.key)">
                            <select required :name="'drive_bays[' + index + '][drive_type]'" id="drive_type">
                                <option disabled selected hidden value="">Drive Type</option>
                                @foreach ($caseSpecs['drive_types'] as $drive_type)
                                    <option value="{{ $drive_type }}">{{ $drive_type }}</option>
                                @endforeach
                            </select>
                            <input :name="'drive_bays[' + index + '][quantity]'" id="quantity" type="number" step="0.01" placeholder="Quantity" onkeydown="return !['e','E','+','-'].includes(event.key)">
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
                
                {{-- ADD DRIVE BAYS BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add Drive Bay
                </button>
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div >
                        <label for="">Fan <br> Mounts <span x-text="index + 1"></span></label>
                        <div class="w-[80%]">
                            <select required :name="'fan_mount[' + index + '][location]'" id="fanlocation">
                                <option disabled selected hidden value="">Location</option>
                                @foreach ($caseSpecs['locations'] as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <input required :name="'fan_mount[' + index + '][size_mm]'" id="size_mm" type="number" placeholder="Size 00 mm" onkeydown="return !['e','E','+','-'].includes(event.key)">
                            <input required :name="'fan_mount[' + index + '][quantity]'" placeholder="Quantity" onkeydown="return !['e','E','+','-'].includes(event.key)">
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
                
                {{-- ADD DRIVE BAYS BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add Fan Mount
                </button>
            </div>

            <div class="flex flex-col"
                 x-data="{ slots:[{}] }">
                <template x-for="(slot, index) in slots" 
                          :key="index">
                    <div >
                        <label for="">Front USB <br> Ports <span x-text="index + 1"></span></label>
                        <div class="w-[80%]">
                            <select required :name="'front_usb[' + index + '][version]'" id="version">
                                <option disabled selected hidden value="">Location</option>
                                @foreach ($caseSpecs['versions'] as $version)
                                    <option value="{{ $version }}">{{ $version }}</option>
                                @endforeach
                            </select>
                            <select required :name="'front_usb[' + index + '][connector]'" id="connector">
                                <option disabled selected hidden value="">Location</option>
                                @foreach ($caseSpecs['connectors'] as $connector)
                                    <option value="{{ $connector }}">{{ $connector }}</option>
                                @endforeach
                            </select>
                            <input :name="'front_usb[' + index + '][quantity]'" id="quantity" type="number" step="0.01" placeholder="Quantity" onkeydown="return !['e','E','+','-'].includes(event.key)">
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
                
                {{-- ADD USB PORTS BUTTON --}}
                <button type="button"
                        @click="slots.push({})"
                        class="add-pcie">
                    + Add USB Ports
                </button>
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
                    @foreach ($caseSpecs['buildCategories'] as $buildCategory)
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