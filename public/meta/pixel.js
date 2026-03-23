
function addToCartEvent(productName, value) {
    fbq('track', 'AddToCart', {
        content_name: productName || 'Vatahari Vati',
        // content_category: 'Ayurvedic Product',
        value: value || 0,
        currency: 'INR'
    });
}

function buyNowEvent(productName, value) {
    fbq('track', 'InitiateCheckout', {
        content_name: productName || 'Vatahari Vati',
        value: value || 0,
        currency: 'INR'
    });
}


function trackAndSubmit(e) {
    e.preventDefault();
    fbq('track', 'checkout');
    setTimeout(() => e.target.form.submit(), 500);
}
