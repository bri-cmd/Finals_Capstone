<x-dashboardlayout>
    <h2>Component Details</h2>

    <div class="header-container" x-data="{ showAddModal: false, componentModal: null }">
        <button class="modal-button" @click="showAddModal = true">
            Add New Component
        </button>

        <div>
            <form action="">
                <input 
                    type="text"
                    name="search"
                    placeholder="Search components"
                    class="search-bar"
                >
                <button type='submit'>
                    <x-icons.search class="search-icon"/>
                </button>
            </form>
        </div>
    
        {{-- ADD COMPONENT MODAL --}}
        <div x-show="showAddModal" x-cloak x-transition class="modal">
            <div class="add-component" @click.away="showAddModal = false">
                <x-modals.addnewcomponent/>
            </div>
        </div>

        {{-- COMPONENT MODALS --}}
        {{-- BASE CODE FOR THE FOREACH LOOP --}}
        {{-- <div x-show="componentModal === 'cpu'" x-cloak x-transition class="modal">
            <div class="add-component" @click.away="componentModal = null; showAddModal = true;">
                <x-modals.cpu/>
            </div>
        </div> --}}

        @foreach (['cpu', 'gpu', 'ram', 'motherboard', 'storage', 'psu', 'case'] as $type)
            <div x-show="componentModal === '{{ $type }}'" x-cloak x-transition class="modal modal-scroll">
                <div class="new-component" @click.away="componentModal = null; showAddModal = true;">
                    <x-dynamic-component 
                        :component="'modals.' . $type" 
                        :brands="$brands"
                        :socketTypes="$socketTypes"
                        :chipsets="$chipsets"
                        :formFactors="$formFactors" 
                        :ramTypes="$ramTypes"
                        :maxRams="$maxRams"
                        :ramSlots="$ramSlots"
                        :versions="$versions"
                        :laneTypes="$laneTypes"
                        :quantities="$quantities"
                        :lengths="$lengths"
                        :m2Versions="$m2Versions"
                        :m2LaneTypes="$m2LaneTypes"
                        :supportSatas="$supportSatas"
                        :m2quantities="$m2quantities"
                        :sataVersions="$sataVersions"
                        :sataQuantities="$sataQuantities"
                        :usbVersions="$usbVersions"
                        :locations="$locations"
                        :types="$types"
                        :usbQuantities="$usbQuantities">
                        <button @click="componentModal = null; showAddModal = true;">
                            <x-icons.arrow class="new-component-arrow"/>
                        </button>
                    </x-dynamic-component>
                </div>
            </div>
        @endforeach
        
        {{-- EDIT AREA (MODAL) --}}
        {{-- <div class="modal modal-scroll">
            <div class="new-component" @click.away="showAddModal = false">
                <x-modals.ram/>
            </div>
        </div> --}}
    </div>



    {{-- TABLE --}}
    <section class="section-style !pl-0 !h-[50vh]">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table> 
        </div>

        <div x-data="{ showViewModal: false, selectedComponent:{} }">
            <table class="table">
                <tbody>
                    @foreach ($mobos as $mobo)
                    <tr>
                        <td>{{ $mobo->brand}} {{ $mobo->model }}</td>
                        <td>Gaming</td>
                        <td>{{ $mobo->price}}</td>
                        <td>{{ $mobo->stock}}</td>
                        <td class="align-middle text-center">
                            <div class="flex justify-center gap-2">
                                <button @click="showViewModal = true; selectedComponent = {{ $mobo->toJson() }}">
                                    <x-icons.view/>    
                                </button>
                                <button>
                                    <x-icons.edit/>    
                                </button>
                                <button>
                                    <x-icons.delete/>    
                                </button>
                            </div>
                        </td>
                    </tr>    
                    @endforeach
                </tbody>
            </table>

            {{-- VIEW MODAL --}}
            <div x-show="showViewModal" x-cloak x-transition class="modal modal-scroll">
            {{-- <div class="modal modal-scroll"> --}}
                <div class="view-component" @click.away="showViewModal = false">
                    <x-modals.componentdetails.view/>
                </div>
            </div>
        </div>

        
    </section>

</x-dashboardlayout>