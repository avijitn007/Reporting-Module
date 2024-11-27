// Start: Sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebarOverlay = document.querySelector('.sidebar-overlay');
const sidebarMenu = document.querySelector('.sidebar-menu');
const main = document.querySelector('.main');

sidebarToggle.addEventListener('click', function (e) {
    e.preventDefault();
    main.classList.toggle('active');
    sidebarOverlay.classList.toggle('hidden');
    sidebarMenu.classList.toggle('-translate-x-full');
});

sidebarOverlay.addEventListener('click', function (e) {
    e.preventDefault();
    main.classList.remove('active');
    sidebarOverlay.classList.add('hidden');
    sidebarMenu.classList.add('-translate-x-full');
});

document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = item.closest('.group');
        parent.classList.toggle('selected');
        if (!parent.classList.contains('selected')) {
            document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (i) {
                i.closest('.group').classList.remove('selected');
            });
        }
    });
});
// End: Sidebar

// Start: Dropdown Menu
document.addEventListener('click', function (e) {
    const toggle = e.target.closest('.dropdown-toggle');
    const menu = e.target.closest('.dropdown-menu');
    if (toggle) {
        const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu');
        const popperId = menuEl.dataset.popperId;
        if (menuEl.classList.contains('hidden')) {
            
            menuEl.classList.remove('hidden');
            showPopper(popperId);
        } else {
            menuEl.classList.add('hidden');
            hidePopper(popperId);
        }
    } 
});
// End: Popper  

// Function to populate the affiliate dropdown from local storage
function populateAffiliateDropdown() {
    const affiliates = JSON.parse(localStorage.getItem('affiliates')) || [];
    const affiliateSelect = document.getElementById('affiliateSelect');

    // Clear existing options
    affiliateSelect.innerHTML = '<option value="" disabled selected>Select Affiliate</option>';

    affiliates.forEach(affiliate => {
        const option = document.createElement('option');
        option.value = affiliate.name; // Use affiliate name as value
        option.textContent = affiliate.name; // Display affiliate name
        affiliateSelect.appendChild(option);
    });
}


   
// Call this on page load to populate dropdown
window.onload = function() {
    // populateAffiliateDropdown();
};
// Function to add an affiliate
function addAffiliate() {
    // Get values from form inputs
    const logoUpload = document.getElementById('logoUpload').files[0];
    const affiliateName = document.getElementById('affiliateName').value;
    const affiliateEmail = document.getElementById('affiliateEmail').value;
    const affiliatePhone = document.getElementById('affiliatePhone').value;

    // Check if fields are filled out
    if (!affiliateName || !affiliateEmail || !affiliatePhone) {
        alert('All fields except the logo is required!');
        return;
    }

    // Read the logo file and store the data in localStorage
    const reader = new FileReader();
    reader.onload = function (e) {
        const logoUrl = e.target.result;

        // Create an affiliate object
        const affiliate = {
            logo: logoUrl,
            name: affiliateName,
            email: affiliateEmail,
            phone: affiliatePhone,
        };

        // Store the affiliate in localStorage
        let affiliates = JSON.parse(localStorage.getItem('affiliates')) || [];
        affiliates.push(affiliate);
        localStorage.setItem('affiliates', JSON.stringify(affiliates));

        // Display the new affiliate in the table and populate the dropdown
        displayAffiliates();
        populateAffiliateDropdown(); // Call this after adding an affiliate
    };
    reader.readAsDataURL(logoUpload);

    // Clear form inputs after adding
    document.getElementById('affiliateName').value = '';
    document.getElementById('affiliateEmail').value = '';
    document.getElementById('affiliatePhone').value = '';
    document.getElementById('logoUpload').value = '';
}

// Function to display affiliates in a table
function displayAffiliates() {
    const affiliates = JSON.parse(localStorage.getItem('affiliates')) || [];
    const tableBody = document.getElementById('affiliatesList');
    tableBody.innerHTML = ''; // Clear previous table rows

    affiliates.forEach((affiliate, index) => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="px-2 py-3 border"><img src="${affiliate.logo}" alt="Logo" class="w-auto h-8 object-contain object-center mx-auto" /></td>
            <td class="px-2 py-3 border">${affiliate.name}</td>
            <td class="px-2 py-3 border">${affiliate.email}</td>
            <td class="px-2 py-3 border">${affiliate.phone}</td>
            <td class="px-2 py-3 border min-w-[50px] align-middle text-center">
                <button onclick="removeAffiliate(${index})" class="bg-red-700 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
}

// Function to remove an affiliate
function removeAffiliate(index) {
    let affiliates = JSON.parse(localStorage.getItem('affiliates')) || [];
    
    // Remove affiliate from the array
    affiliates.splice(index, 1);
    
    // Update local storage
    localStorage.setItem('affiliates', JSON.stringify(affiliates));
    
    // Refresh the displayed affiliates
    displayAffiliates();
}
// Display affiliates and populate dropdown when the page loads
window.onload = function() {
    // displayAffiliates();
    // populateAffiliateDropdown(); // Populate dropdown on page load
};

// Submit the affiliate form
document.addEventListener('DOMContentLoaded', function () {
    const affiliateForm = document.getElementById('affiliateForm');
    
    if (affiliateForm) {
        affiliateForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Affiliates have been submitted!');
            // Further handling (e.g., sending data to the server) would go here.
        });
    }
});


// Function to toggle child row visibility
function toggleRow(row) {
    const nextRow = row.nextElementSibling;
    if (nextRow && nextRow.classList.contains('child-row')) {
        nextRow.classList.toggle('hidden');
    }
}




//////////////////////////

// Disable add row button if no affiliate is selected
function toggleAddRowButton() {
    const affiliateSelect = document.getElementById('affiliateSelect').value;
    const addRowButton = document.querySelector('button[onclick="addChildRow(this)"]');
    addRowButton.disabled = !affiliateSelect; // Disable if no affiliate is selected
}

// Add a new row
function addChildRow(button) {
    const tableBody = document.querySelector('#dynamicTable tbody');
    const row = button.closest('tr');
    const newRow = row.cloneNode(true); // Clone the row
    let rowNum = tableBody.childElementCount+1;

    // Clear input values in new row
    const inputs = newRow.querySelectorAll('input');
    inputs.forEach(input => input.value = '');
    inputs.forEach((input) => input.name='row['+rowNum+']['+input.dataset.name+']');
    newRow.querySelector('.rowid').innerHTML = rowNum;

    // Prepend new row at the top of the table
    // tableBody.insertBefore(newRow, tableBody.firstChild);
    tableBody.appendChild(newRow);
    
    // Update buttons after adding a row
    updateRowButtons();
}

// Remove a row
function removeRow(button) {
    const row = button.closest('tr');
    const rows = row.parentNode.querySelectorAll('tr');
    if (rows.length > 1) {
        row.remove(); // Remove the row
    } else {
        alert('At least one row is required.');
    }
    // Update buttons after removing a row
    updateRowButtons();
}

// Update buttons to show only "+" on the last row and "-" on others
function updateRowButtons() {
    const rows = document.querySelectorAll('#dynamicTable tbody tr');
    
    rows.forEach((row, index) => {
        const addButton = row.querySelector('.add-row');
        const removeButton = row.querySelector('.remove-row');

        // Show "+" only on the last row and "-" on every row
        if (index === rows.length - 1) {
            addButton.style.display = 'inline-flex'; // Show "+" on last row
        } else {
            addButton.style.display = 'none'; // Hide "+" on other rows
        }

        // removeButton.style.display = 'inline-flex'; // Show "-" on all rows
    });
}

// Initial button state on page load
window.onload = updateRowButtons;
