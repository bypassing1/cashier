
<div class="product-detail bg-gray-700 bg-opacity-50 rounded-lg p-4 mb-6" >
    <div class="w-full h-auto mb-4 rounded-lg relative">
        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto">
        <div class="absolute inset-0 bg-gradient-to-t from-red-900 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
            <button class="delete bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full mb-4 transition duration-300 cursor-pointer" data-product-id="{{ $product->id }}">
                Hapus
            </button>
        </div>
    </div>
<h3 class="text-xl font-semibold mb-2 text-cyan-300">{{ $product->name }}</h3>
<p class="text-gray-300">{{ $product->description }}</p>
<p class="barcode text-white text-4xl">{{ $product->barcode}}</p>
<p class="font-semibold text-2xl text-green-400">Rp. {{ number_format($product->price, 2) }}</p>
<p class="mb-2 text-gray-400">Kuantitas:
    <input 
        class="text-cyan-300 bg-gray-800 border border-cyan-500 rounded-md px-2 py-1 w-16 text-center outline-none focus:ring-2 focus:ring-cyan-400"
        type="number"
        min="1"
        max="{{ $product->stock }}"
        value="1">
</p>

<p class="mb-2 text-gray-400">Kategori: <span class="text-cyan-300">{{ $product->category->name }}</span></p>
</div>