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
        'resources\css\buildext.css',
        'resources\js\app.js',
        'resources\js\buildext.js',
        'resources\css\admin-staff\modal.css',
        ])
    
</head>
<body class="flex"
      x-data="{ showViewModal: false, selectedComponent:{} }">
    @if (session('message'))
        <x-message :type="session('type')">
            {{ session('message') }}
        </x-message>
    @endif

    <header>
        <div class="header-logo">
            <img src="{{ asset('images\Logo.png') }}" alt="Logo" class="logo">
            <h2>Madoxx.qwe</h2>    
        </div>
    </header>

    <main class="main-content header overflow-hidden">
        <h2 class="text-center">YOUR PC</h2>

        <section class="model-section">
            <div id="canvas-container"></div>
        </section>

        <div class="layout-container">
            {{-- STEPS --}}
            <section class="steps-section">

            </section>

            {{-- COMPATIBILITY --}}
            <section class="compatibility-section">

            </section>

            {{-- COMPONENTS --}}
            <section class="catalog-wrapper">
                <div class="slide-container">
                    <div class="component-section">
                        <x-icons.arrow class="component-arrow" />
                        <x-component data-type="case">Case</x-component>
                        <x-component data-type="cpu">CPU</x-component>
                        <x-component data-type="ram">RAM</x-component>
                        <x-component data-type="ssd">SSD</x-component>
                        <x-component data-type="motherboard">Motherboard</x-component>
                        <x-component data-type="gpu">GPU</x-component>
                        <x-component data-type="hdd">HDD</x-component>
                        <x-component data-type="psu">PSU</x-component>
                        <x-component data-type="cooler">Cooler</x-component>
                    </div>

                    <div class="catalog-section" id="catalogSection">
                        @foreach ($components as $component)
                            <x-buildcatalog :component="$component"/>
                        @endforeach
                    </div>
                </div>

                
            </section>
        </div>
    </main>

    <div x-show="showViewModal" x-cloak x-transition class="modal view-specs modal-scroll">
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

            <div x-show="selectedComponent.component_type === 'ssd' || selectedComponent.component_type === 'hdd'">
                @include('staff.componentdetails.view.storage')
            </div>

            <div x-show="selectedComponent.component_type === 'cpu'">
                @include('staff.componentdetails.view.cpu')
            </div>

            <div x-show="selectedComponent.component_type === 'cooler'">
                @include('staff.componentdetails.view.cooler')
            </div>
        </div>
    </div>
</body>