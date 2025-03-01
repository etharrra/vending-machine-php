@extends('layouts.app')

@section('title', 'Purchase Product')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif    

        <h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-6">Purchase Product</h2>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $product->name }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Price: ${{ number_format($product->price, 2) }}</p>
            <p class="text-gray-600 dark:text-gray-400">Available: {{ $product->quantity_available }}</p>
        </div>

        <form action="{{ route('products.purchase', $product->id) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Quantity</label>
                <input type="number" name="quantity" min="1" max="{{ $product->quantity_available }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    required>
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('dashboard') }}" 
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Confirm Purchase
                </button>
            </div>
        </form>
    </div>
</div>
@endsection