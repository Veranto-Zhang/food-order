document.addEventListener("DOMContentLoaded", function () {
    const cartContainer = document.querySelector(".flex.flex-col.gap-3");

    function updateSummary() {
        let subtotal = 0;

        document.querySelectorAll(".cart-item").forEach(item => {
            const subtotalEl = item.querySelector(".subtotal");
            const subtotalText = subtotalEl.textContent.replace(/[^\d]/g, "");
            subtotal += parseInt(subtotalText || 0);
        });

        const tax = Math.round(subtotal * 0.11);
        const grandtotal = subtotal + tax;

        const subtotalBox = document.getElementById("subtotal");
        const taxBox = document.getElementById("tax");
        const grandtotalBox = document.getElementById("grandtotal");
        const grandtotalBot = document.getElementById("grandtotal-bot");
        const navbarTotal = document.querySelector(".navigation-bar #grandtotal");

        if(subtotalBox) subtotalBox.textContent = "Rp " + subtotal.toLocaleString("id-ID");
        if(taxBox) taxBox.textContent = "Rp " + tax.toLocaleString("id-ID");
        if(grandtotalBox) grandtotalBox.textContent = "Rp " + grandtotal.toLocaleString("id-ID");
        if(grandtotalBot) grandtotalBot.textContent = "Rp " + grandtotal.toLocaleString("id-ID");
        if(navbarTotal) navbarTotal.textContent = "Rp " + grandtotal.toLocaleString("id-ID");
    }

    cartContainer.addEventListener("click", function (e) {
        const btn = e.target.closest(".add-quantity, .remove-quantity");
        if (!btn) return;

        const itemRow = btn.closest(".cart-item");
        const quantityEl = itemRow.querySelector(".quantity");
        const subtotalEl = itemRow.querySelector(".subtotal");
        const itemPrice = parseInt(itemRow.dataset.itemprice);

        let quantity = parseInt(quantityEl.textContent);

        if(btn.classList.contains("add-quantity")) {
            quantity++;
        } else if(btn.classList.contains("remove-quantity")) {
            if(quantity > 1) {
                quantity--;
            } else {
                // Remove item if quantity is 1
                itemRow.remove();
                updateSummary();

                // Update session for removal
                fetch("/cart/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ menu_id: menuId, quantity: 0 })
                });
                return;
            }
        }

        quantityEl.textContent = quantity;
        subtotalEl.textContent = "Rp " + (quantity * itemPrice).toLocaleString("id-ID");
        updateSummary();
    });

    // Initial summary calculation
    updateSummary();
});

