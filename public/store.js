// Show installment options only for the simulated card payment.
const paymentChoices = document.querySelectorAll('[name="forma_pagto"]');
const installments = document.querySelector('#installments');
for (const choice of paymentChoices) {
    choice.addEventListener('change', () => {
        installments.hidden = choice.value !== 'Cartão';
    });
}

// Postal-code mask is presentation only; the server also validates the input.
const postalCode = document.querySelector('#cep');
postalCode?.addEventListener('input', () => {
    const digits = postalCode.value.replace(/\D/g, '').slice(0, 8);
    postalCode.value = digits.length > 5
        ? digits.slice(0, 5) + '-' + digits.slice(5)
        : digits;
});

// Native dialog supports keyboard focus and Escape without extra dependencies.
const zoom = document.querySelector('#product-zoom');
document.querySelector('[data-zoom]')?.addEventListener('click', () => zoom.showModal());
document.querySelector('[data-close-zoom]')?.addEventListener('click', () => zoom.close());
zoom?.addEventListener('click', (event) => {
    if (event.target !== zoom) return;
    const bounds = zoom.getBoundingClientRect();
    if (event.clientX < bounds.left || event.clientX > bounds.right ||
        event.clientY < bounds.top || event.clientY > bounds.bottom) {
        zoom.close();
    }
});
