@extends('layouts.transaction-app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3 bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-6 border border-gray-700">
            <h2 class="text-2xl font-bold mb-6 text-cyan-400">Your Cart</h2>
            <div id="cart-items">
                <p class="text-gray-400">Loading cart items...</p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3 bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-6 border border-gray-700 h-fit">
            <h2 class="text-2xl font-bold mb-6 text-cyan-400">Order Summary</h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-400">Subtotal</span>
                    <span id="subtotal" class="text-white">Rp0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">PPN (11%)</span>
                    <span id="tax" class="text-white">Rp0</span>
                </div>
                <div class="border-t border-gray-700 pt-4">
                    <div class="flex justify-between">
                        <span class="text-lg font-bold text-gray-300">Total</span>
                        <span id="total" class="text-lg font-bold text-green-400">Rp0</span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label for="payment-method" class="text-gray-300">Payment Method</label>
                <select id="payment-method" class="w-full bg-gray-700 text-white py-2 px-3 rounded mt-2">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="digital">Digital</option>
                </select>
            </div>
            
            <div class="mt-8 space-y-4">
                <button id="checkout-btn" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-4 rounded transition duration-300">
                    Proceed to Checkout
                </button>                
                <button class="w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded transition duration-300">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", async function () {
    const cartItemsDiv = document.getElementById("cart-items");
    let selectedProducts = JSON.parse(localStorage.getItem("selectedProducts")) || [];

    if (selectedProducts.length === 0) {
        cartItemsDiv.innerHTML = "<p class='text-gray-400'>Your cart is empty.</p>";
        return;
    }

    // Extract product IDs and request full product details
    const productIds = selectedProducts.map(p => p.id).join(",");
    const response = await fetch(`/api/products?ids=${productIds}`);
    const products = await response.json();

    if (products.length === 0) {
        cartItemsDiv.innerHTML = "<p class='text-gray-400'>Your cart is empty.</p>";
        return;
    }

    // Map products to quantities stored in localStorage
    const cartData = selectedProducts.map(item => {
        const product = products.find(p => p.id == item.id);
        return { ...product, quantity: item.quantity || 1 };
    });

    let subtotal = 0;
    cartItemsDiv.innerHTML = "";

    cartData.forEach((item, index) => {
        subtotal += item.price * item.quantity;

        const itemDiv = document.createElement("div");
        itemDiv.classList.add("flex", "items-center", "justify-between", "border-b", "border-gray-700", "py-4");
        itemDiv.innerHTML = `
            <div class="flex items-center space-x-4">
                <img src="${item.image}" alt="${item.name}" class="w-16 h-16 rounded-md">
                <div>
                    <h3 class="text-lg font-semibold text-cyan-300">${item.name}</h3>
                    <p class="text-sm text-gray-400">${item.category || "Uncategorized"}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center border border-gray-600 rounded-md">
                    <button class="px-3 py-1 bg-gray-700 text-gray-300 hover:bg-gray-600 rounded-l-md cursor-pointer" onclick="updateQuantity(${index}, 'decrease')">-</button>
                    <span class="px-3 py-1 bg-gray-800 text-gray-300">${item.quantity}</span>
                    <button class="px-3 py-1 bg-gray-700 text-gray-300 hover:bg-gray-600 rounded-r-md cursor-pointer" onclick="updateQuantity(${index}, 'increase')">+</button>
                </div>
                <p class="text-lg font-bold text-green-400">Rp${(item.price * item.quantity).toLocaleString()}</p>
                <button class="text-red-500 hover:text-red-600 cursor-pointer " onclick="removeItem(${index})">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        cartItemsDiv.appendChild(itemDiv);
    });

    // Calculate order summary
    const tax = subtotal * 0.11;
    const total = subtotal + tax;
    document.getElementById("subtotal").textContent = `Rp${subtotal.toLocaleString()}`;
    document.getElementById("tax").textContent = `Rp${tax.toLocaleString()}`;
    document.getElementById("total").textContent = `Rp${total.toLocaleString()}`;
});

// Update quantity in localStorage
function updateQuantity(index, type) {
    let cart = JSON.parse(localStorage.getItem("selectedProducts")) || [];
    if (type === 'increase') cart[index].quantity++;
    else if (type === 'decrease' && cart[index].quantity > 1) cart[index].quantity--;

    localStorage.setItem("selectedProducts", JSON.stringify(cart));
    location.reload();
}

document.getElementById("checkout-btn").addEventListener("click", async function () {
    let cart = JSON.parse(localStorage.getItem("selectedProducts")) || [];
    let paymentMethod = document.getElementById("payment-method").value;
    
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    let response = await fetch("/api/checkout", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cart, paymentMethod })
    });

    let result = await response.json();
    if (result.success) {
        localStorage.removeItem("selectedProducts");
        alert("Transaction successful!");
        location.href = "/dashboard"; 
    } else {
        alert("Transaction failed!");
    }
});


// Remove item from cart
function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem("selectedProducts")) || [];
    cart.splice(index, 1);
    localStorage.setItem("selectedProducts", JSON.stringify(cart));
    location.reload();
}
</script>
@endsection
