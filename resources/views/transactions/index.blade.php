@extends('layouts.app')

@section('title', 'Transactions List')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 shadow-md">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-1 px-2 border border-gray-300">ID</th>
                    <th class="py-1 px-2 border border-gray-300">User</th>
                    <th class="py-1 px-2 border border-gray-300">Product</th>
                    <th class="py-1 px-2 border border-gray-300">Quantity</th>
                    <th class="py-1 px-2 border border-gray-300">Total Price</th>
                    <th class="py-1 px-2 border border-gray-300">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr class="text-gray-900 dark:text-white">
                    <td class="py-3 px-2 border border-gray-300 text-center">{{ $transaction->id }}</td>
                    <td class="py-3 px-2 border border-gray-300">{{ $transaction->user->name }}</td>
                    <td class="py-3 px-2 border border-gray-300">{{ $transaction->product->name }}</td>
                    <td class="py-3 px-2 border border-gray-300">{{ $transaction->quantity }}</td>
                    <td class="py-3 px-2 border border-gray-300 text-center">{{ number_format($transaction->total_price, 2) }}</td>
                    <td class="py-3 px-2 border border-gray-300 text-center">{{ $transaction->created_at }}</td>         
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection