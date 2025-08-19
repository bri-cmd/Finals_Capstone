import * as THREE from 'https://esm.sh/three@0.155.0';
import { GLTFLoader } from 'https://esm.sh/three@0.155.0/examples/jsm/loaders/GLTFLoader.js';

// Store Three.js stuff to global scope
window.THREE = THREE;
window.GLTFLoader = GLTFLoader;

window.loadModel = function () {
    const canvas = document.getElementById('modelCanvas');
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
    renderer.setSize(canvas.width, canvas.height);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, canvas.width / canvas.height, 0.1, 1000);
    camera.position.z = 5;

    const light = new THEE.HemisphereLight(0xffffff, 0x444444, 1.5);
    scene.add(light);

    const loader = new GLTFLoader();

    const modelPath = window.selectedComponent?.model_3d;

    if (!modelPath) {
        console.warn("No 3D model path found.");
        return;
    }
    console.log("Model path from selectedComponent:", modelPath);

    // loader.load(`/storage/${modelPath}`, function (gltf) {
    //     const model = gltf.scene;
    //     scene.add(model);
    //     model.scale.setScalar(.5);
    //     model.rotation.y = Math.PI;

    //     function animate() {
    //         requestAnimationFrame(animate);
    //         model.rotation.y += 0.005;
    //         renderer.render(scene, camera);
    //     }

    //     animate();
    // }, undefined, function (error) {
    //     console.error("Error loading GLTF model:", error);
    // });

    loader.load(`/storage/${modelPath}`, function (gltf) {
    const model = gltf.scene;
    
    // Replace all materials with basic ones to avoid shader issues
    model.traverse(function (child) {
        if (child.isMesh) {
            // Use a basic material to bypass shaders
            child.material = new THREE.MeshBasicMaterial({
                color: 0x00ff00, // simple green color
                wireframe: true // optional, wireframe mode for debugging
            });
        }
    });
    
    scene.add(model);
    model.scale.setScalar(0.5);
    model.rotation.y = Math.PI;

    function animate() {
        requestAnimationFrame(animate);
        model.rotation.y += 0.005;
        renderer.render(scene, camera);
    }

    animate();
}, undefined, function (error) {
    console.error("Error loading GLTF model:", error);
});

};