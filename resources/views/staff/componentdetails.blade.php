<x-dashboardlayout>
    <h2>Component Details</h2>

    <div class="header-container" x-data="{ showAddModal: false, componentModal: null }">
        <button class="modal-button" @click="showAddModal = true">
            Add New Component
        </button>

        <div>
            <form action=" {{ route('staff.componentdetails.search') }}" method="GET">
                <input 
                    type="text"
                    name="search"
                    placeholder="Search components"
                    value="{{ request('search') }}"
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
                @include('staff.componentdetails.add.addnewcomponent')
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
                    <button @click="componentModal = null; showAddModal = true;">
                        <x-icons.arrow class="new-component-arrow"/>
                    </button>
                    @include('staff.componentdetails.add.' . $type, [
                        'moboSpecs' => $moboSpecs,
                        'gpuSpecs' => $gpuSpecs,
                        'caseSpecs' => $caseSpecs,
                        'psuSpecs' => $psuSpecs,
                        'ramSpecs' => $ramSpecs,
                        'storageSpecs' => $storageSpecs,
                        'cpuSpecs' => $cpuSpecs,
                    ])
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
    <section class="section-style !pl-0 !h-[65vh]">
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

        <div x-data="{ showViewModal: false, showEditModal: false, selectedComponent:{} }" 
             x-init="$watch('selectedComponent', value => window.selectedComponent = value)" class="overflow-y-scroll">
            <table class="table">
                <tbody>
                    @foreach ($components as $component)
                    <tr>
                        <td>{{ $component->brand}} {{ $component->model }}</td>
                        <td>{{ $component->buildCategory->name}}</td>
                        <td>₱{{ number_format($component->price, 2) }}</td>
                        <td>{{ $component->stock}}</td>
                        <td class="align-middle text-center">
                            <div class="flex justify-center gap-2">
                                <button @click="showViewModal = true; selectedComponent = {{ $component->toJson() }};">
                                    <x-icons.view/>    
                                </button>
                                <button @click="showEditModal = true; selectedComponent = {{ $component->toJson() }};">
                                    <x-icons.edit/>    
                                </button>
                                <form action="{{ route('staff.componentdetails.delete', ['type' =>$component->component_type, 'id' => $component->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" ><x-icons.delete /></button>
                                </form>
                            </div>
                        </td>
                    </tr>    
                    @endforeach
                </tbody>
            </table>

            {{-- VIEW MODAL --}}
            <div x-show="showViewModal" x-cloak x-transition class="modal modal-scroll">
                <div class="view-component" @click.away="showViewModal = false">
                    <div x-show="selectedComponent.component_type === 'motherboard'">
                        @include('staff.componentdetails.view.motherboard')
                    </div>

                    <div x-show="selectedComponent.component_type === 'gpu'">
                        @include('staff.componentdetails.view.gpu')
                    </div>

                    <div x-show="selectedComponent.component_type === 'case'">
                        @include('staff.componentdetails.view.case')
                    </div>

                    <div x-show="selectedComponent.component_type === 'psu'">
                        @include('staff.componentdetails.view.psu')
                    </div>

                    <div x-show="selectedComponent.component_type === 'ram'">
                        @include('staff.componentdetails.view.ram')
                    </div>

                    <div x-show="selectedComponent.component_type === 'storage'">
                        @include('staff.componentdetails.view.storage')
                    </div>

                    <div x-show="selectedComponent.component_type === 'cpu'">
                        @include('staff.componentdetails.view.cpu')
                    </div>
                </div>
            </div>

            {{-- EDIT MODAL --}}
            <div x-show="showEditModal" x-cloak x-transition class="modal modal-scroll">
                <div class="new-component" @click.away="showEditModal = false">
                    <div x-show="selectedComponent.component_type === 'motherboard'">
                        @include('staff.componentdetails.edit.motherboard')
                    </div>

                    <div x-show="selectedComponent.component_type === 'gpu'">
                        @include('staff.componentdetails.edit.gpu')
                    </div>

                    <div x-show="selectedComponent.component_type === 'case'">
                        @include('staff.componentdetails.edit.case')
                    </div>

                    <div x-show="selectedComponent.component_type === 'psu'">
                        @include('staff.componentdetails.edit.psu')
                    </div>

                    <div x-show="selectedComponent.component_type === 'ram'">
                        @include('staff.componentdetails.edit.ram')
                    </div>

                    <div x-show="selectedComponent.component_type === 'storage'">
                        @include('staff.componentdetails.edit.storage')
                    </div>

                    <div x-show="selectedComponent.component_type === 'cpu'">
                        @include('staff.componentdetails.edit.cpu')
                    </div>
                </div>
            </div>
        </div>

        
    </section>

</x-dashboardlayout>