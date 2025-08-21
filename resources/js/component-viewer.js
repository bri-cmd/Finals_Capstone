import * as THREE from 'https://esm.sh/three@0.155.0';
import { OrbitControls } from 'https://esm.sh/three@0.155.0/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'https://esm.sh/three@0.155.0/examples/jsm/loaders/GLTFLoader.js';
import interact from 'https://esm.sh/interactjs@1.10.17';


let scene, camera, renderer, controls;
let caseModel = null;
let gpuModel = null;
let gpuSlotPosition = null;

init();
animate();

function init() {
  scene = new THREE.Scene();
  scene.background = new THREE.Color('white');

  const container = document.getElementById('canvas-container');
  const width = container.clientWidth;
  const height = container.clientHeight;

  camera = new THREE.PerspectiveCamera(30, width/height, 0.1, 1000);
  camera.position.set(20, 0, 0);

  renderer = new THREE.WebGLRenderer({antialias: true});
  renderer.setSize(width, height);
  container.appendChild(renderer.domElement);

  controls = new OrbitControls(camera, renderer.domElement);

  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5); 
  scene.add(ambientLight);

  const directionalLight = new THREE.DirectionalLight(0xffffff, 7.0); // LIGHT SETTINGS HITTING THE MODEL
  directionalLight.position.set(2, 10, 5);
  scene.add(directionalLight);

  // RESIZE LISTENER USING CONTAINER SIZE
  window.addEventListener('resize', () => {
    const width = container.clientWidth;
    const height = container.clientHeight;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });

  setupDragAndDrop();
}

function animate() {
  requestAnimationFrame(animate);
  renderer.render(scene, camera);
}

async function loadGLTFModel(url) {
  const loader = new GLTFLoader();
  const gltf = await loader.loadAsync(url);
  return gltf.scene;
}

function setupDragAndDrop() {
  let draggingId = null;
  let draggingEl = null;
  let originalSlotMaterial = null;
  let casemarker = null;
  let gpumarker = null;

  interact('.draggable').draggable({
    listeners: {
      start(event) {
        draggingId = event.target.id;
        draggingEl = event.target;
        draggingEl.style.opacity = '0.5';

        if (draggingId === 'case' && !caseModel) {
          // Show a drop zone marker for the case
          casemarker = new THREE.Mesh(
            new THREE.BoxGeometry(4, 4, 4), // Adjust size to match case model scale
            new THREE.MeshStandardMaterial({
              color: 0x0000ff,       // Blue casemarker
              emissive: 0x000066,
              transparent: true,
              opacity: 0.3
            })
          );

          // Place casemarker at a default drop area (e.g. center of canvas)
          casemarker.position.set(0, 0, 0);
          scene.add(casemarker);
        }

        // If dragging GPU, highlight the GPU slot
        if (draggingId === 'gpu' && caseModel) {
          const gpuSlot = caseModel.getObjectByName('Slot_GPU');
          if (gpuSlot) {
            // Save the original material and change to the highlighted one
            originalSlotMaterial = gpuSlot.material; // Store the original material
            gpuSlot.material = new THREE.MeshStandardMaterial({
              color: 0x00ff00,        // Bright green to show it's active
              emissive: 0x003300,     // A little glowing effect
              transparent: true,
              opacity: 0.4,           // Semi-transparent
            });

            // Optionally, create a visible marker at the slot position
            gpumarker = new THREE.Mesh(
              new THREE.BoxGeometry(2, 2, 0.1),
              new THREE.MeshStandardMaterial({
                color: 0x00ff00,
                emissive: 0x003300,
                transparent: true,
                opacity: 0.4,
              })
            );

            
            // Rotate 45 degrees on the X axis
            gpumarker.rotation.x = 0; // No rotation on the Y axis
            gpumarker.rotation.y = Math.PI / 2;  // 90 degrees        
            gpumarker.rotation.z = 0;          // No rotation on the Z axis
            gpumarker.position.set(gpuSlotPosition.x, gpuSlotPosition.y + -1, gpuSlotPosition.z + -1.4); // Position the gpumarker
            scene.add(gpumarker);
          }
        }
      },
      move(event) {
        // Optional: Add extra visual feedback during dragging if necessary
      },
      end(event) {
        draggingEl.style.opacity = '1';

        const dropPos = getCanvasDropPosition(event.clientX, event.clientY);

        // If the drop position is valid, spawn the models
        if (dropPos && draggingId === 'case' && !caseModel) {
          spawnCase(dropPos);
        } else if (dropPos && draggingId === 'gpu' && caseModel) {
          spawnGPUAtSlot();
        }

        // Revert the slot highlight after dragging ends
        if (casemarker) {
          scene.remove(casemarker);
          casemarker = null;
        }
        if (gpumarker) {
          scene.remove(gpumarker);
          gpumarker = null;
        }

        if (originalSlotMaterial) {
          const gpuSlot = caseModel.getObjectByName('Slot_GPU');
          if (gpuSlot) {
            gpuSlot.material = originalSlotMaterial; // Restore the original material
          }
        }

        // Reset dragging state
        draggingId = null;
        draggingEl = null;
        originalSlotMaterial = null;
      }
    }
  });
}


function getCanvasDropPosition(clientX, clientY) {
  const rect = renderer.domElement.getBoundingClientRect();

  if (
    clientX < rect.left || clientX > rect.right ||
    clientY < rect.top || clientY > rect.bottom
  ) {
    return null;
  }

  const x = ((clientX - rect.left) / rect.width) * 2 - 1;
  const y = - ((clientY - rect.top) / rect.height) * 2 + 1;

  const mouseVector = new THREE.Vector2(x, y);
  const raycaster = new THREE.Raycaster();

  raycaster.setFromCamera(mouseVector, camera);

  const planeZ = new THREE.Plane(new THREE.Vector3(0, 0, 1), 0);
  const intersectionPoint = new THREE.Vector3();

  raycaster.ray.intersectPlane(planeZ, intersectionPoint);

  return intersectionPoint;
}

async function spawnCase(position) {
  if (caseModel) return; // only one case at a time

  try {
    const model = await loadGLTFModel('/storage/case/try5.glb');
    model.position.copy(position);
    model.scale.setScalar(1); // Shrinks uniformly
    scene.add(model);
    caseModel = model;

    // CONTROL THE ROTATION || FOCUS THE ROTATION ON THE MODEL
    controls.target.copy(model.position);
    controls.update();

    const gpuSlot = model.getObjectByName('Slot_GPU');
    if (gpuSlot) {
      gpuSlotPosition = new THREE.Vector3();
      gpuSlot.getWorldPosition(gpuSlotPosition);
      console.log('GPU slot position:', gpuSlotPosition);
    } else {
      gpuSlotPosition = new THREE.Vector3(0, 0, 0);
      console.warn('GPU slot not found in case model');
    }
  } catch (error) {
    console.error('Failed to load case model', error);
  }
}

async function spawnGPUAtSlot() {
  if (!gpuSlotPosition) {
    alert('GPU slot position unknown');
    return;
  }
  if (gpuModel) {
    scene.remove(gpuModel);
    gpuModel = null;
  }
  try {
    const model = await loadGLTFModel('/storage/cpu/MOBO3.glb');
    model.position.copy(gpuSlotPosition);
    scene.add(model);
    gpuModel = model;
  } catch (error) {
    console.error('Failed to load GPU model', error);
  }
}
