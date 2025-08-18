<h2 class="text-center !relative">View</h2>
<div class="view-container">
    {{-- IMAGE --}}
    <div class="image-container" x-show="selectedComponent.image && selectedComponent.image.length">
        <template x-for="fileId in selectedComponent.image">
            <img :src="`https://drive.google.com/thumbnail?id=${fileId}`" class="image-container">
        </template>
        
        <div x-show="showViewModal" x-init="$watch('selectedComponent', value => { window.selectedComponent = value; loadModel(); })">
            <canvas id="modelCanvas" width="400" height="400"></canvas>
        </div>
    </div>

    <div x-show="!selectedComponent.image || selectedComponent.image.length === 0">
        <p>No image uploaded.</p>
    </div>
    {{-- SPECS --}}
    <div class="specs-container">
        <div>
            <p>Brand</p>
            <p x-text="selectedComponent.brand"></p>
        </div>
        <div>
            <p>Model</p>
            <p x-text="selectedComponent.model"></p>
        </div>
        <div>
            <p>Wattage</p>
            <p x-text="selectedComponent.wattage + ' W'"></p>
        </div>
        <div>
            <p>Efficiency Rating</p>
            <p x-text="selectedComponent.efficiency_rating"></p>
        </div>
        <div>
            <p>Modular </p>
            <p x-text="selectedComponent.modular"></p>
        </div>
        <div>
            <p>No. of PCIe Connector</p>
            <p x-text="selectedComponent.pcie_connectors"></p>
        </div>
        <div>
            <p>No. of Sata Connectors</p>
            <p x-text="selectedComponent.sata_connectors"></p>
        </div>
        <div>
            <p>Price </p>
            <p x-text="selectedComponent.price_display"></p>
        </div>
        <div>
            <p>Stock </p>
            <p x-text="selectedComponent.stock"></p>
        </div>
    </div>
</div>

<script type="module">
        import * as THREE from 'https://esm.sh/three@0.155.0';
        import { GLTFLoader } from 'https://esm.sh/three@0.155.0/examples/jsm/loaders/GLTFLoader.js';

        // Store Three.js stuff to global scope
        window.THREE = THREE;
        window.GLTFLoader = GLTFLoader;
</script>

<script>

        window.loadModel = function () {
            const canvas = document.getElementById('modelCanvas');
            const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
            renderer.setSize(canvas.width, canvas.height);

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, canvas.width / canvas.height, 0.1, 1000);
            camera.position.z = 5;

            const light = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
            scene.add(light);

            const loader = new GLTFLoader();

            // Get the model path from the Alpine.js component
            const modelPath = window.selectedComponent?.model_3d;

            if (!modelPath) {
                console.warn("No 3D model path found.");
                return;
            }
            console.log("Model path from selectedComponent:", modelPath);

            loader.load(`/storage/${modelPath}`, function (gltf) {
                const model = gltf.scene;
                scene.add(model);
                model.scale.setScalar(.5); // Shrinks uniformly


                model.rotation.y = Math.PI; // Optional: adjust rotation

                function animate() {
                    requestAnimationFrame(animate);
                    model.rotation.y += 0.005; // Rotate model
                    renderer.render(scene, camera);
                }

                animate();
            }, undefined, function (error) {
                console.error("Error loading GLTF model:", error);
            });

            // Get the model path from the Alpine.js component
            // const modelPath = '/storage/product_3d/Case.glb';

            // if (!modelPath) {
            //     console.warn("No 3D model path found.");
            //     return;
            // }

            // loader.load(modelPath, function (gltf) {
            //     const model = gltf.scene;
            //     scene.add(model);

            //     model.rotation.y = Math.PI; // Optional: adjust rotation

            //     function animate() {
            //         requestAnimationFrame(animate);
            //         model.rotation.y += 0.005; // Rotate model
            //         renderer.render(scene, camera);
            //     }

            //     animate();
            // }, undefined, function (error) {
            //     console.error("Error loading GLTF model:", error);
            // });
        };
</script>