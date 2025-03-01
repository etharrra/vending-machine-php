<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ApiTransactionController extends Controller
{
    public function apiIndex()
    {
        $transactions = Transaction::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }

    public function apiShow($id)
    {
        $transaction = Transaction::with(['user', 'product'])->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ]);
    }
}
