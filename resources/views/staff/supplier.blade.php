<x-dashboardlayout>
    <h2>Supplier</h2>

    <div class="header-container" x-data="{ showAddModal: false, showAddBrandModal: false }">
        <div>
            <button class="modal-button" @click="showAddModal = true">
                Add Supplier
            </button>
            <button class="modal-button" @click="showAddBrandModal = true">
                Add Brand
            </button>    
        </div>
        
        {{-- STOCK-IN MODAL --}}
        <div x-show="showAddModal" x-cloak x-transition class="modal">
            <div class="add-component" @click.away="showAddModal = false">
                <h2 class="text-center">SUPPLIER FORM</h2>
                <form class="inventory-form" method="POST" action="{{ route('staff.supplier.store') }}">
                    @csrf
                    <div>
                        <label for="">Supplier Name</label>
                        <input required type="text" name="name">
                    </div>
                    <div>
                        <label for="">Contact Person</label>
                        <input required type="text" name="contact_person">
                    </div>
                    <div>
                        <label for="">Email</label>
                        <input required type="email" name="email">
                    </div>
                    <div>
                        <label for="">Contact number</label>
                        <input required name="phone" id="phone" type="number" onkeydown="return !['e','E','+','-'].includes(event.key)">
                    </div>    
                    <div>
                        <button>Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ADD BRAND MODAL --}}
        <div x-show="showAddBrandModal" x-cloak x-transition class="modal">
            <div class="add-component" @click.away="showAddBrandModal = false">
                <h2 class="text-center">BRAND FORM</h2>
                <form class="inventory-form" method="POST" action="{{ route('staff.supplier.store.brand') }}">
                    @csrf
                    <div>
                        <label for="">Supplier</label>
                        <select name="supplier_id" id="supplier_id">
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="">Brand</label>
                        <input required type="text" name="name" id="name">
                    </div>
                    <div>
                        <button>Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section-style !pl-0 !h-[65vh]">
        <div x-data="{ showViewModal: false, currentSupplier: null, showEditModal: false }">
            <table class="table mb-3">
                <thead>
                    <tr>
                        <th>Supplier Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->contact_person}}</td>
                            <td>{{$supplier->email}}</td>
                            <td>{{$supplier->phone}}</td>
                            <td>{{ $supplier->status ? 'Inactive' : 'Active' }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <button @click="showViewModal = true" currentSupplier = {{ $supplier->toJson() }};>
                                        <x-icons.view/>    
                                    </button>
                                    <button  @click="showEditModal = true">
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
            <div x-show="showViewModal" x-cloak x-transition class="modal">
                <div class="modal-form" @click.away="showViewModal = false">
                    <h2>View</h2>
                    <div class="specs-container">
                        <div>
                            <p>Supplier Name</p>
                            <p x-text="currentSupplier ? currentSupplier.name : ''"></p>    
                        </div>
                    </div>
                </div>
            </div>

            {{-- EDIT MODAL --}}
            <div x-show="showEditModal" x-cloak x-transition class="modal">
                <div class="modal-form" @click.away="showEditModal = false">
                    <h2>Edit</h2>
                </div>
            </div>
        </div>
        
        {{ $suppliers->links() }}
    </section>
</x-dashboardlayout>