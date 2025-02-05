function filterByCategory(category, btn) {
    // Reset all category buttons to the default state
    let buttons = document.querySelectorAll('.category-btn');
    buttons.forEach(button => {
        button.classList.remove('bg-transparent', 'border-cyan-400');
        button.classList.add('bg-cyan-700');
    });

    // Set the clicked button to have the selected state
    btn.classList.remove('bg-cyan-700');
    btn.classList.add('bg-transparent', 'border', 'border-cyan-400');

    let products = document.querySelectorAll('.product-card');

    products.forEach(product => {
        let productCategory = product.getAttribute('data-category');

        if (category === 'all' || productCategory === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Function for search functionality
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