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
        'resources\js\app.js'])
</head>
<body class="flex">

    @if (session('message'))
        <x-message :type="session('type')">
            {{ session('message') }}
        </x-message>
    @endif

    <x-buildheader />

    <main class="main-content flex justify-evenly">
        <section class="preview-section">
            <p>preview</p>
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
            <div>
                <button><p>Budget</p></button>
                <button><p>Input Budget Box</p></button>
            </div>
            <button><p>Generate Build</p></button>
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
                <div class="catalog-item">
                    <div>
                        <img src="https://th.bing.com/th/id/OIP.BUTK95nR9fMRPV2THBgwPAHaFj?w=264&h=198&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3" alt="product">
                    </div>
                    <div class="catalog-specs">
                        <p>CPU</p>
                        <p>AMD RYZEM 7 5800X</p>
                        <p>₱ 23,550</p>
                    </div>
                </div>
                <div class="catalog-item">
                    <div>
                        <img src="https://th.bing.com/th/id/OIP.BUTK95nR9fMRPV2THBgwPAHaFj?w=264&h=198&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3" alt="product">
                    </div>
                    <div class="catalog-specs">
                        <p>CPU</p>
                        <p>AMD RYZEM 7 5800X</p>
                        <p>₱ 23,550</p>
                    </div>
                </div>
                <div class="catalog-item">
                    <div>
                        <img src="https://th.bing.com/th/id/OIP.BUTK95nR9fMRPV2THBgwPAHaFj?w=264&h=198&c=7&r=0&o=7&dpr=1.7&pid=1.7&rm=3" alt="product">
                    </div>
                    <div class="catalog-specs">
                        <p>CPU</p>
                        <p>AMD RYZEM 7 5800X</p>
                        <p>₱ 23,550</p>
                    </div>
                </div>
            </div>
        </section>    
    </main>
    
    
</body>
</html>