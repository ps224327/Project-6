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
