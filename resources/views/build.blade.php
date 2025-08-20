<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Techboxx</title>

    @vite([
        'resources\css\app.css',
        'resources\css\landingpage\header.css',
        'resources\css\build.css',
        'resources\js\app.js',
        'resources\js\component-viewer.js'
        ])
    
</head>
<body class="flex">

    @if (session('message'))
        <x-message :type="session('type')">
            {{ session('message') }}
        </x-message>
    @endif

    <x-buildheader :name="Auth::user()?->first_name" />

    <main class="main-content flex justify-evenly h-[91vh] gap-1">
        <section class="preview-section">
            <div id="sidebar">
                <h3 class="mb-3">BUILD COMPONENTS</h3>
                <div id="components">
                    <div id="case" class="draggable"><p>PC Case</p></div>
                    <div id="gpu" class="draggable"><p>GPU</p></div>
                    <div id="mobo" class="draggable"><p>Motherboard</p></div>
                    <div id="cpu" class="draggable"><p>CPU</p></div>
                    <div id="hdd" class="draggable"><p>HDD</p></div>
                    <div id="sdd" class="draggable"><p>SDD</p></div>
                    <div id="psu" class="draggable"><p>PSU</p></div>    
                    <div id="ram" class="draggable"><p>RAM</p></div>    
                </div>
            </div>
            <div id="canvas-container"></div>

        </section>
        <section class="buttons-section">
            <div>
                <button><p>Custom Build</p></button>
                <button><p>Generate Build</p></button>
            </div>
            <div>
                <button><p>AMD</p></button>
                <button><p>Intel</p></button>
            </div>
            <div>
                <button><p>General Use</p></button>
                <button><p>Gaming</p></button>
                <button><p>Graphics Intensive</p></button>
            </div>
            <div class="budget-section">
                <button><p>Budget</p></button>
                <input name="budget" id="budget" type="number" step="0.01" placeholder="Enter budget" onkeydown="return !['e','E','+','-'].includes(event.key)">
            </div>
            <div class="generate-button">
                <button id="generateBtn"><p>Generate Build</p></button>
            </div>

            {{-- THIS SECTION WILL SHOW WHEN GENERATE BUILD IS CLICKED --}}
            <div class="generate-build hidden" id="buildSection">
                <button><p>Case</p></button>
                <button><p>GPU</p></button>
                <button><p>Motherboard</p></button>
                <button><p>CPU</p></button>
                <button><p>HDD</p></button>
                <button><p>SDD</p></button>
                <button><p>PSU</p></button>
                <button><p>RAM</p></button>
            </div>
        </section>   
        <section class="catalog-section">
            <div class="catalog-button">
                <button>Components</button>
                <button>Summary</button>
            </div>
            <div class="catalog-header">
                <div class="catalog-title">
                    <p>Processor</p>
                    <x-icons.info />
                </div> 
                <div class="catalog-filter">
                    <button><p>filter</p></button>
                    <button><p>filter</p></button>    
                </div>
            </div>
            <div class="catalog-list">
                @foreach ($components as $component)
                <div class="catalog-item">
                    <div class="catalog-image">
                        @if (!empty($component->image))
                            <img src="{{ asset('storage/' . $component->image )}}" alt="Product image">
                        @else
                            <p>No image uploaded.</p>
                        @endif
                    </div>
                    <div class="catalog-specs">
                        <p>{{ ucfirst($component->component_type) }}</p>
                        <p><strong>{{ $component->brand}} {{ $component->model }}</strong></p>
                        <p>₱{{ number_format($component->price, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>    
    </main>
    
    <script>
        document.querySelectorAll('.buttons-section button').forEach(button => {
            button.addEventListener('click', () => {
                // REMOVE ACTIVE CLASS FROM ALL THE BUTTONS IN THE SAVE GROUP (DIV)
                const siblings = button.parentElement.querySelectorAll('button');
                siblings.forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');
            });
        });

        document.getElementById('generateBtn').addEventListener('click', () => {
            // HIDE BUDGET SECTION AND GENERATE BUTTON
            document.querySelector('.generate-button').classList.add('hidden');
            document.querySelector('.budget-section').classList.add('hidden');

            // SHOW BUILD SECTION
            document.getElementById('buildSection').classList.remove('hidden');
        })
    </script>
    
</body>
</html>