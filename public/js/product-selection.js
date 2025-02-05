document.addEventListener('DOMContentLoaded', function () {
    // Attach product card listeners initially
    attachProductCardListeners();

    function attachProductCardListeners() {
        const productCards = document.querySelectorAll('.product-card');
        const sidebarContainer = document.querySelector('.container');

        productCards.forEach(card => {
            card.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const existingProduct = sidebarContainer.querySelector(`.product-detail[data-product-id="${productId}"]`);

                if (existingProduct) {
                    existingProduct.remove();
                    card.classList.remove('border-cyan-500');
                    card.classList.add('border-gray-700');
                } else {
                    fetch(`/product/${productId}`)
                        .then(response => response.text())
                        .then(html => {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;
                            const productDetail = tempDiv.firstElementChild;

                            productDetail.dataset.productId = productId;

                            sidebarContainer.appendChild(productDetail);
                            card.classList.add('border-cyan-500');
                            card.classList.remove('border-gray-700');

                            attachDeleteEvent();
                        });
                }
            });
        });
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

        if (productDetail) {
            productDetail.remove();
        }

        const originalCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
        if (originalCard) {
            originalCard.classList.remove('border-cyan-500');
            originalCard.classList.add('border-gray-700');
        }
    }

    // Search functionality
    function searchProducts() {
        let query = document.getElementById('searchInput').value.toLowerCase();
        let products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            let productName = product.getAttribute('data-name');

            if (productName.includes(query)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('input', searchProducts);
});
