<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        $low_stock_products = Product::where('quantity_available', '<', 10)->paginate(10);
        return view('dashboard', compact('products', 'low_stock_products'));
    }
}
