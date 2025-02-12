document.addEventListener('DOMContentLoaded', function () {
    let selectedProducts = JSON.parse(localStorage.getItem("selectedProducts")) || []; // Load from localStorage

    attachProductCardListeners();

    function attachProductCardListeners() {
        const productCards = document.querySelectorAll('.product-card');
        const sidebarContainer = document.querySelector('.container');

        productCards.forEach(card => {
            card.addEventListener('click', function () {
                const productId = this.dataset.productId;

                const existingProductIndex = selectedProducts.findIndex(p => p.id === productId);

                if (existingProductIndex !== -1) {
                    // Remove product if already selected
                    selectedProducts.splice(existingProductIndex, 1);
                    removeProductFromSidebar(productId);
                } else {
                    // Fetch product details and add to sidebar
                    fetch(`/product/${productId}`)
                        .then(response => response.text())
                        .then(html => {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;
                            const productDetail = tempDiv.firstElementChild;

                            productDetail.dataset.productId = productId;
                            sidebarContainer.appendChild(productDetail);

                            const quantityInput = productDetail.querySelector("input[type='number']");
                            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
                            
                            selectedProducts.push({ id: productId, quantity: quantity });

                            card.classList.add('border-cyan-500');
                            card.classList.remove('border-gray-700');

                            attachDeleteEvent();
                            attachQuantityChangeEvent();
                        });
                }
            });
        });
    }

    function removeProductFromSidebar(productId) {
        const productDetail = document.querySelector(`.product-detail[data-product-id="${productId}"]`);
        if (productDetail) productDetail.remove();

        selectedProducts = selectedProducts.filter(p => p.id !== productId);

        const originalCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
        if (originalCard) {
            originalCard.classList.remove('border-cyan-500');
            originalCard.classList.add('border-gray-700');
        }
    }

    function attachDeleteEvent() {
        document.querySelectorAll('.delete').forEach(button => {
            button.removeEventListener('click', handleDelete);
            button.addEventListener('click', handleDelete);
        });
    }

    function handleDelete(event) {
        const productDetail = event.target.closest('.product-detail');
        const productId = productDetail.dataset.productId;

        removeProductFromSidebar(productId);
    }

    function attachQuantityChangeEvent() {
        document.querySelectorAll(".product-detail input[type='number']").forEach(input => {
            input.addEventListener("change", function () {
                const productId = this.closest('.product-detail').dataset.productId;
                const quantity = parseInt(this.value) || 1;

                const product = selectedProducts.find(p => p.id === productId);
                if (product) {
                    product.quantity = quantity;
                    localStorage.setItem("selectedProducts", JSON.stringify(selectedProducts));
                }
            });
        });
    }

    function searchProducts() {
        let query = document.getElementById('searchInput').value.toLowerCase();
        let products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            let productName = product.getAttribute('data-name').toLowerCase();
            product.style.display = productName.includes(query) ? 'block' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', searchProducts);

    // Handle Beli button click
    const beliButton = document.getElementById("beli-button");
    if (beliButton) {
        beliButton.addEventListener("click", function () {
            if (selectedProducts.length === 0) {
                alert("Pilih minimal satu item sebelum membeli!");
                return;
            }

            localStorage.setItem("selectedProducts", JSON.stringify(selectedProducts));

            // Redirect to transaction page
            window.location.href = "/transaction";
        });
    }
});
