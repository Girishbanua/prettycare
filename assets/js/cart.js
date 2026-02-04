function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function addToCart(id, name, price) {
    let cart = getCart();
    let item = cart.find(p => p.id === id);

    if (item) {
        item.qty += 1;
    } else {
        cart.push({ id, name, price, qty: 1 });
    }

    saveCart(cart);
    alert("Product added to cart");
}

function removeFromCart(id) {
    let cart = getCart().filter(item => item.id !== id);
    saveCart(cart);
    location.reload();
}

function updateQty(id, qty) {
    let cart = getCart();
    cart.forEach(item => {
        if (item.id === id) item.qty = qty;
    });
    saveCart(cart);
    location.reload();
}