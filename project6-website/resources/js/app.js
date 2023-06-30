import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';

document.addEventListener('DOMContentLoaded', function () {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');

    quantityInputs.forEach(function (input) {
        const cartItemId = input.id.split('_')[1];
        const minusButton = input.parentNode.querySelector('button[value="decrease"]');
        const plusButton = input.parentNode.querySelector('button[value="increase"]');

        minusButton.addEventListener('click', function () {
            updateQuantity(cartItemId, input, -1);
        });

        plusButton.addEventListener('click', function () {
            updateQuantity(cartItemId, input, 1);
        });
    });

    function updateQuantity(itemId, input, change) {
        let newQuantity = parseInt(input.value) + change;
        newQuantity = newQuantity >= 0 ? newQuantity : 0;
        input.value = newQuantity;
    }
});

// Preload product images
const images = document.querySelectorAll('img[data-src]');
images.forEach((image) => {
    const src = image.getAttribute('data-src');
    if (src) {
        const img = new Image();
        img.src = src;
        img.onload = () => {
            image.src = src;
        };
    }
});

// Search functionality
const searchInput = document.getElementById('search');
searchInput.addEventListener('input', function () {
    const filter = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const name = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
        row.style.display = name.includes(filter) ? '' : 'none';
    });
});

// Role checkbox changes
const roleCheckboxes = document.querySelectorAll('input[type="checkbox"]');
roleCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const employeeId = checkbox.id.split('_')[1];
        const enabled = checkbox.checked;

        // Send an AJAX request to update the role status
        fetch(`/employees/${employeeId}/toggle-role`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ enabled })
        })
            .then(response => response.json())
            .then(data => {
                // Handle success or error response if needed
            })
            .catch(error => {
                // Handle error if needed
            });
    });
});