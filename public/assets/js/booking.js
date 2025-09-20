function calculatePrice() {
    let quantity = parseInt(document.getElementById("quantity").textContent);
    let menuPrice = parseInt(document.getElementById("menuPrice").value);
    let extraPrice = 0;

    // kumpulkan semua input yg terpilih
    document.querySelectorAll("input[type=radio]:checked, input[type=checkbox]:checked")
        .forEach(input => {
            let extra = parseInt(input.dataset.extra || 0);
            extraPrice += extra;
        });

    let subTotal = (menuPrice + extraPrice) * quantity;

    document.getElementById("quantity").textContent = quantity;

    document.getElementById("subtotal").textContent =
        "Rp " + subTotal.toLocaleString("id");
}

function addQuantity() {
    let quantityElement = document.getElementById("quantity");
    let quantityInput = document.getElementById("quantity_input");
    let quantity = parseInt(quantityElement.textContent);
    quantity++;
    quantityInput.value = quantity; // Update hidden input
    quantityElement.textContent = quantity;
    calculatePrice();
}

function removeQuantity() {
    let quantityInput = document.getElementById("quantity_input");
    let quantityElement = document.getElementById("quantity");
    let quantity = parseInt(quantityElement.textContent);
    if (quantity > 1) {
        // Prevents quantity from going below 1
        quantity--;
        quantityInput.value = quantity; // Update hidden input
        quantityElement.textContent = quantity;
        calculatePrice();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("add-quantity")
        .addEventListener("click", addQuantity);
    document
        .getElementById("remove-quantity")
        .addEventListener("click", removeQuantity);

    document.querySelectorAll("input[type=radio], input[type=checkbox]").forEach(input => {
            input.addEventListener("change", calculatePrice);
        });

    calculatePrice(); // Initial calculation
});
