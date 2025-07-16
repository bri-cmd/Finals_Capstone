<x-dashboardlayout>
    <h2>Component Details</h2>

    <div class="header-container">
        <button>
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
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</x-dashboardlayout>