@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="overflow-x-auto">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Edit Product</h2>
        
            <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
        
                <!-- Product Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" maxlength="255"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Price -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0.01"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Quantity Available -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Quantity Available</label>
                    <input type="number" name="quantity_available" min="1" value="{{ old('quantity_available', $product->quantity_available) }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('quantity_available')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Buttons -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</a>
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
