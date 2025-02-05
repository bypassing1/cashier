@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Category Buttons -->
    <div class="grid grid-cols-7 gap-4 mb-6">
        <button id="allCategory" class="category-btn bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300"
            onclick="filterByCategory('all', this)">
            Semua
        </button>
        @foreach($categories as $category)
            <button id="category-{{ $category->name }}" class="category-btn bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300"
                onclick="filterByCategory('{{ $category->name }}', this)">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <!-- Search Bar -->
    <div class="flex justify-center mb-6">
        <input type="text" id="searchInput" placeholder="Cari produk..."
            class="w-1/2 p-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-cyan-500 focus:outline-none"
            oninput="searchProducts()">
    </div>

    <!-- Product Grid -->
    <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($products as $product)
            <div class="product-card bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-4 border border-gray-700 hover:border-cyan-400 transition duration-300 cursor-pointer"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-category="{{ $product->category ? $product->category->name : 'Tidak ada kategori' }}">
                <div class="relative mb-4 h-[16rem]">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full rounded-md">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                        <button class="add-to-cart bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-full mb-4 transition duration-300" data-product-id="{{ $product->id }}">
                            Tambah
                        </button>
                    </div>
                </div>
                <h3 class="text-lg font-semibold mb-1 text-cyan-300">{{ $product->name }}</h3>
                <h2 class="text-lg mb-1 text-cyan-500">{{ $product->category ? $product->category->name : 'Tidak ada kategori' }}</h2>
                <p class="text-sm text-gray-400 ">{{$product->description}}</p>
                <h3 class="text-lg font-semibold mb-1 text-red-300">Stok : {{ $product->stock }}</h3>
                <p class="font-bold text-green-400">Rp. {{ number_format($product->price, 2) }}</p>
            </div>
        @endforeach
    </div>
</div>

<script>
// Function to filter products by category
function filterByCategory(categoryName) {
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const productCategory = card.dataset.productCategory;
        if (categoryName === 'all' || productCategory.toLowerCase() === categoryName.toLowerCase()) {
            card.style.display = 'block'; // Show matching product
        } else {
            card.style.display = 'none'; // Hide non-matching product
        }
    });
}

// Function to search products by name
function searchProducts() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const productName = card.dataset.productName.toLowerCase();
        if (productName.includes(searchInput)) {
            card.style.display = 'block'; // Show matching product
        } else {
            card.style.display = 'none'; // Hide non-matching product
        }
    });
}

// Optional: Initialize category filter to 'all' when page loads
document.addEventListener('DOMContentLoaded', () => {
    filterByCategory('all'); // Show all products initially
});
</script>
@endsection
