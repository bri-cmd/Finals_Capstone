<x-dashboardlayout>
    <section class="section-style ">
        <h2 class="section-header">Add New Software</h2>

        <form action="" class="software-form">
            @csrf
            <div class="flex gap-4">
                <div class="flex flex-col gap-1">
                    <div class="input-label">
                        <label for="">Software Name</label>
                        <input required type="text">
                    </div>

                    <div class="input-label">
                        <label for="">Software Icon</label>
                        <input required type="text">
                    </div>    
                </div>
                <div>
                    <div class="input-label">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="pt-0 pb-0 pl-1">
                            <option disabled selected hidden value="">Select build category</option>   
                            @foreach ($buildCategories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>     
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex flex-col gap-1">
                    <p>Minimum System Requirements</p>

                    <div class="input-label">
                        <label for="">CPU</label>
                        <input required type="text">
                        <div>
                            <select name="category" id="category" class="pt-0 pb-0 pl-1">
                                <option disabled selected hidden value="">Select build category</option>   
                                @foreach ($buildCategories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            <select name="category" id="category" class="pt-0 pb-0 pl-1">
                                <option disabled selected hidden value="">Select build category</option>   
                                @foreach ($buildCategories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="input-label">
                        <label for="">GPU</label>
                        <input required type="text">
                    </div>   

                    <div class="input-label">
                        <label for="">RAM</label>
                        <input required type="text">
                    </div>   

                    <div class="input-label">
                        <label for="">Storage</label>
                        <input required type="text">
                    </div>   
                </div>
                <div class="flex flex-col gap-1">
                    <p>Recommended System Requirements</p>
                    
                    <div class="input-label">
                        <label for="">CPU</label>
                        <input required type="text">
                    </div>   

                    <div class="input-label">
                        <label for="">GPU</label>
                        <input required type="text">
                    </div>   

                    <div class="input-label">
                        <label for="">RAM</label>
                        <input required type="text">
                    </div>   

                    <div class="input-label">
                        <label for="">Storage</label>
                        <input required type="text">
                    </div> 
                </div>
            </div>

            <button class="form-button">Add Software</button>

        </form>
    </section>
    <section class="section-style">
        <h2 class="section-header">Software Dashboard</h2>
        
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>    
        </div>

        <div class="table-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Ambottt</td>
                        <td>Ambottt</td>
                        <td>Ambottt</td>
                    </tr>
                </tbody>
            </table>    
        </div>
    </section>

</x-dashboardlayout>
