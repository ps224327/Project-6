import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');

    quantityInputs.forEach(function(input) {
        const cartItemId = input.id.split('_')[1];
        const minusButton = input.parentNode.querySelector('button[value="decrease"]');
        const plusButton = input.parentNode.querySelector('button[value="increase"]');

        minusButton.addEventListener('click', function() {
            updateQuantity(cartItemId, input, -1);
        });

        plusButton.addEventListener('click', function() {
            updateQuantity(cartItemId, input, 1);
        });
    });

    function updateQuantity(itemId, input, change) {
        let newQuantity = parseInt(input.value) + change;
        newQuantity = newQuantity >= 0 ? newQuantity : 0;
        input.value = newQuantity;
    }
});
