<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ApiProductController extends Controller
{
    public function apiIndex()
    {
        try {
            $products = Product::orderBy('id', 'asc')->paginate(10);
            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch products'
            ], 500);
        }
    }

    public function apiShow($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
    }

    public function apiStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0.01',
                'quantity_available' => 'required|integer|min:0',
            ]);

            $product = Product::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create product'
            ], 500);
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0.01',
                'quantity_available' => 'required|integer|min:0',
            ]);

            $product = Product::findOrFail($id);
            $product->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product'
            ], 500);
        }
    }

    public function apiDestroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product'
            ], 500);
        }
    }

    public function apiPurchase(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $product = Product::findOrFail($id);
            $user = $request->user(); // Get authenticated user

            if ($product->quantity_available < $validated['quantity']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not enough quantity available'
                ], 400);
            }

            DB::beginTransaction();

            try {
                $product->quantity_available -= $validated['quantity'];
                $product->save();

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $validated['quantity'],
                    'total_price' => $product->price * $validated['quantity'],
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product purchased successfully',
                    'data' => $transaction
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
