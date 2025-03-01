@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-12">
        @if (Auth::user()->role == "user")
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex md:flex-row gap-6">
                <div class="w-full text-gray-900 dark:text-white">
                @foreach ($products as $product)
                <div class="mb-4 p-4 border border-gray-200">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <span class="text-orange-500 font-bold">${{ $product->price }}</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="block text-gray-700">Available Quantity: {{ $product->quantity_available }}</span>
                        <a href="{{ route('products.purchase', $product->id) }}" class="block hover:underline bg-green-600 text-center px-2 py-2 text-white rounded-lg transition duration-300">Purchase</a>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>
        
        @else

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Admin Dashboard</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300">Total Products</h3>
                        <p class="text-3xl font-bold text-blue-800 dark:text-blue-200">{{ $products->total() }}</p>
                    </div>
                    
                    <div class="col-span-2 space-y-4">
                        <div class="flex gap-4">
                            <a href="{{ route('products.index') }}" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Manage Products
                            </a>
                            <a href="{{ route('transactions.index') }}" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                View Transactions
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Low Stock Products</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($low_stock_products as $product)
                                @if ($product->quantity_available > 10)
                                    @continue
                                @endif
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $product->quantity_available }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $low_stock_products->links() }}
                </div>
            </div>
        </div>
            
        @endif

    </div>
@endsection