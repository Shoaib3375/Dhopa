<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string',
            'schedule' => 'required|date',
            'total_price' => 'required|numeric',
            'pickup_address' => 'required|string',
            'delivery_address' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'service_type' => $request->service_type,
            'status' => 'pending',
            'schedule' => $request->schedule,
            'total_price' => $request->total_price,
            'pickup_address' => $request->pickup_address,
            'delivery_address' => $request->delivery_address,
            'special_instructions' => $request->special_instructions,
            'payment_status' => 'pending',
        ]);

        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }
}
