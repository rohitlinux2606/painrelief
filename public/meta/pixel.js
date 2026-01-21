
function addToCartEvent() {
    fbq('track', 'AddToCart', {
        content_name: 'Vatahari Vati',
        content_category: 'Ayurvedic Product',
        value: 1,
        currency: 'INR'
    });
}

function buyNowEvent() {
    fbq('track', 'InitiateCheckout', {
        content_name: 'Vatahari Vati',
        value: 1,
        currency: 'INR'
    });
}


function trackAndSubmit(e) {
    e.preventDefault();
    fbq('track', 'checkout');
    setTimeout(() => e.target.form.submit(), 500);
}
