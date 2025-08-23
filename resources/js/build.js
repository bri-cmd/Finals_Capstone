let filters = {
    cpu: null,
    useCase: null,
    budget: null,
}
let shouldAutoGenerate = true;

document.getElementById('amdBtn').addEventListener('click', () => {
    filters.cpu = 'AMD';
    sessionStorage.setItem('filters', JSON.stringify(filters));
    if (shouldAutoGenerate) tryAutoGenerate();
});

document.getElementById('intelBtn').addEventListener('click', () => {
    filters.cpu = 'Intel';
    sessionStorage.setItem('filters', JSON.stringify(filters));
    if (shouldAutoGenerate) tryAutoGenerate();
});

document.getElementById('generalUseBtn').addEventListener('click', () => {
    filters.useCase = 'General Use';
    sessionStorage.setItem('filters', JSON.stringify(filters));
    if (shouldAutoGenerate) tryAutoGenerate();
});

document.getElementById('gamingBtn').addEventListener('click', () => {
    filters.useCase = 'Gaming';
    sessionStorage.setItem('filters', JSON.stringify(filters));
    if (shouldAutoGenerate) tryAutoGenerate();
});

document.getElementById('graphicsIntensiveBtn').addEventListener('click', () => {
    filters.useCase = 'Graphics Intensive';
    sessionStorage.setItem('filters', JSON.stringify(filters));
    if (shouldAutoGenerate) tryAutoGenerate();
});


// SEND FILTERS TO BACKEND USING SESSION STORAGE
document.getElementById('generateBtn').addEventListener('click', () => {
    shouldAutoGenerate = true;
    
    const budgetValue = document.getElementById('budget').value;
    if (budgetValue) {
        filters.budget = parseFloat(budgetValue);
    }

    if (!budgetValue) {
        alert('Please enter a budget');
        return;
    }

    sessionStorage.setItem('filters', JSON.stringify(filters));
    sessionStorage.setItem('showBuildSection', true);

    // Generate query parameters
    const queryParams = new URLSearchParams(filters).toString();

    window.location.href = `/techboxx/build/generate?${queryParams}`; // REDIRRECT TO GENERATE ROUTE
})

const catalogList = document.querySelector('.catalog-list');
const customBuildBtn = document.getElementById('customBuildBtn');
const generateBuildBtn = document.getElementById('generateBuildBtn');
const buildSection = document.getElementById('buildSection');

// SHOW CATALOG WHEN CUSTOM BUILD BUTTON IS CLICKED
customBuildBtn.addEventListener('click', () => {
    shouldAutoGenerate = true;

    document.querySelector('.generate-button').classList.add('hidden');
    document.querySelector('.budget-section').classList.add('hidden');

    catalogList.classList.remove('hidden');
    buildSection.classList.remove('hidden');
})

// HIDE CATALOG WHEN GENERATE BUILD BUTTON IS CLICKED
generateBuildBtn.addEventListener('click', () => {
    shouldAutoGenerate = false;

    document.querySelector('.generate-button').classList.remove('hidden');
    document.querySelector('.budget-section').classList.remove('hidden');

    catalogList.classList.add('hidden');
    buildSection.classList.add('hidden');
})

document.querySelectorAll('.buttons-section button').forEach(button => {
    button.addEventListener('click', () => {
        // REMOVE ACTIVE CLASS FROM ALL THE BUTTONS IN THE SAVE GROUP (DIV)
        const siblings = button.parentElement.querySelectorAll('button');
        siblings.forEach(btn => btn.classList.remove('active'));

        button.classList.add('active');

        const groupKey = button.parentElement.dataset.group;
        if (groupKey) {
            sessionStorage.setItem(`active-${groupKey}`, button.id);
        };
    });
});

window.addEventListener('DOMContentLoaded', () => {
    // RESTORE FILTERS STATE
    const savedFilters = sessionStorage.getItem('filters');
    if (savedFilters) {
        try {
            const parsed = JSON.parse(savedFilters);
            if (parsed.cpu) filters.cpu = parsed.cpu;
            if (parsed.useCase) filters.useCase = parsed.useCase;
        } catch (e) {
            console.error("Invalid filters in sessionStorage");
        }
    }

    // RESTORE ACTIVE BUTTON STATES
    const groups = ['buildType', 'cpuBrand', 'useCase'];
    groups.forEach(group => {
        const activeBtnId = sessionStorage.getItem(`active-${group}`);
        if (activeBtnId) {
            const button = document.getElementById(activeBtnId);
            if (button) {
                const siblings = button.parentElement.querySelectorAll('button');
                siblings.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            }
        }
    })

});

// AUTO TRIGGER GENERATE FUNCTION
function tryAutoGenerate() {
    if (filters.cpu && filters.useCase) {
        sessionStorage.setItem('filters', JSON.stringify(filters));
        sessionStorage.setItem('showBuildSection', true);

        const queryParams = new URLSearchParams(filters).toString();
        window.location.href = `/techboxx/build/generate?${queryParams}`; // REDIRRECT TO GENERATE ROUTE
    }
}

document.querySelectorAll('#buildSection button').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');

        // UPDATE CATALOG HEADER TITLE
        const catalogTitle = document.getElementById('catalogTitle');
        catalogTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1);

        document.querySelectorAll('.catalog-item').forEach(item => {
            const itemType = item.getAttribute('data-type');
            if (itemType === type) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        })
    })
});

document.querySelectorAll('.catalog-item').forEach(item => {
    item.addEventListener('click', () => {
        const type = item.getAttribute('data-type');
        const name = item.getAttribute('data-name');
        const price = parseFloat(item.getAttribute('data-price'));
        const imageUrl = item.getAttribute('data-image');

        // STORE SELECTED COMPONENT
        selectedComponents[type] = { name, price, imageUrl };
        sessionStorage.setItem(type, JSON.stringify(selectedComponents));

        // FIND THE MATCHING BUTTON
        const targetButton = document.querySelector(`#buildSection button[data-type="${type}"]`);
        if (targetButton) {
            const span = targetButton.querySelector('.selected-name');
            if (span) {
                span.textContent = name;
            }
        }

        // UPDATE DRAGGABLE IMAGE
        const draggable = document.getElementById(type);
        if (draggable && imageUrl) {
            draggable.innerHTML = `
                <img src="${imageUrl}" alt="${name}" >
                <p>${type.toUpperCase()}</p>
                `;
        }

        updateSummaryTable();
    })
});

document.getElementById('componentsTab').addEventListener('click', () => {
    document.getElementById('componentsSection').classList.remove('hidden');
    document.getElementById('summarySection').classList.add('hidden');
    document.getElementById('componentsTab').classList.add('active');
    document.getElementById('summaryTab').classList.remove('active');

});

document.getElementById('summaryTab').addEventListener('click', () => {
    document.getElementById('componentsSection').classList.add('hidden');
    document.getElementById('summarySection').classList.remove('hidden');
    document.getElementById('componentsTab').classList.remove('active');
    document.getElementById('summaryTab').classList.add('active');
});

// SUMMARY DISPLAY
const selectedComponents = {};

function updateSummaryTable() {
    const tbody = document.querySelector('#summaryTableBody');
    tbody.innerHTML = ''; // CLEAR OLD ENTRIES

    for (const [type, component] of Object.entries(selectedComponents)) {
        const row = document.createElement('tr');

        const nameCell = document.createElement('td');
        nameCell.innerHTML = `<p>${component.name}</p>`;

        const qtyCell = document.createElement('td');
        qtyCell.innerHTML = `<p>1</p>`;

        const priceCell = document.createElement('td');
        priceCell.innerHTML = `<p>₱${component.price.toFixed(2)}</p>`;

        row.appendChild(nameCell);
        row.appendChild(qtyCell);
        row.appendChild(priceCell);

        tbody.appendChild(row);

    }
}

// ADD DATE TODAY ON THE SUMMARY TAB
window.addEventListener('DOMContentLoaded', () => {
    const dateElement = document.getElementById('buildDate');
    if (dateElement) {
        const today = new Date();
        const formatted = today.toLocaleDateString('en-PH', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        }); 
        dateElement.textContent = formatted;
    }
});