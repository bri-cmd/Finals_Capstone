<x-dashboardlayout>
    <h2>Component Details</h2>

    <div class="header-container" x-data="{ showAddModal: false }">
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
    
        {{-- ADD MODALS --}}
        <div x-show="showAddModal" x-cloak x-transition class="modal">
            <div class="add-component" @click.away="showAddModal = false">
                <x-modals.addnewcomponent />
            </div>
        </div>

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

        <div>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Ryzen 5 5600</td>
                        <td>CPU</td>
                        <td>₱12, 500</td>
                        <td>34</td>
                        <td class="align-middle text-center">
                            <div class="flex justify-center gap-2">
                                <x-icons.view/>
                                <x-icons.edit/>
                                <x-icons.delete/>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</x-dashboardlayout>