@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('products.create') }}" class="bg-gray-800 text-white font-bold py-3 px-4 rounded">
            Create New Product
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 shadow-md">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-1 px-2 border border-gray-300">
                        <a href="{{ route('products.index', ['sort' => 'id', 'direction' => $sortField == 'id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            ID
                            @if ($sortField == 'id')
                                @if ($sortDirection == 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-1 px-2 border border-gray-300">
                        <a href="{{ route('products.index', ['sort' => 'name', 'direction' => $sortField == 'name' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Name
                            @if ($sortField == 'name')
                                @if ($sortDirection == 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-1 px-2 border border-gray-300">
                        <a href="{{ route('products.index', ['sort' => 'price', 'direction' => $sortField == 'price' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Price ($)
                            @if ($sortField == 'price')
                                @if ($sortDirection == 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-1 px-2 border border-gray-300">
                        <a href="{{ route('products.index', ['sort' => 'quantity_available', 'direction' => $sortField == 'quantity_available' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Quantity
                            @if ($sortField == 'quantity_available')
                                @if ($sortDirection == 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-1 px-2 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="text-gray-900 dark:text-white">
                    <td class="py-1 px-2 border border-gray-300 text-center">{{ $product->id }}</td>
                    <td class="py-1 px-2 border border-gray-300">{{ $product->name }}</td>
                    <td class="py-1 px-2 border border-gray-300 text-center">{{ number_format($product->price, 2) }}</td>
                    <td class="py-1 px-2 border border-gray-300 text-center">{{ $product->quantity_available }}</td>
                    <td class="py-1 px-2 border border-gray-300">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="hover:underline text-center px-2 py-2 text-gray-900 dark:text-white rounded-lg transition duration-300">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-2 text-red-600 rounded-lg hover:bg-red-600 transition duration-300">Delete</button>
                            </form>
                        </div>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection