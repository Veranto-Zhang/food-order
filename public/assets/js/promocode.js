document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('checkPromoBtn');
    if (!btn) return;

    const route = btn.dataset.route;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.addEventListener('click', function () {
        const code = document.getElementById('promo_code').value.trim();
        const err = document.getElementById('promoError');
        const success = document.getElementById('promoSuccess');

        // Reset messages
        err.classList.add('hidden');
        success.classList.add('hidden');

        if (!code) {
            err.textContent = "Please enter a promo code.";
            err.classList.remove('hidden');
            return;
        }

        this.disabled = true;
        this.textContent = "Checking...";

        fetch(route, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ promo_code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('grandTotal').textContent =
                    "Rp " + new Intl.NumberFormat('id-ID').format(data.new_total);
                success.textContent = `Promo code "${code}" applied successfully!`;
                success.classList.remove('hidden');
            } else {
                err.textContent = data.message;
                err.classList.remove('hidden');
            }
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = "Apply";
        });
    });
});
