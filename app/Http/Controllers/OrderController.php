<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
    {
        public function index() // Fetch all Orders
        {
            return response()->json(Order::with(['product'])->get(),200);
        }
 
        public function deliverOrder(Order $order) //Set status as Order Delivered
        {
            $order->is_delivered = true;
            $status = $order->save();
 
            return response()->json([
                'status'    => $status,
                'data'      => $order,
                'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
            ]);
        }
 
        public function store(Request $request) //Creates an Order
        {
            $order = Order::create($request->all(), [
                'product_id' => 'required|max:50',
                'user_id' => Auth::id(),
                'quantity' => 'required|min:3',
                'address' => 'required',
            ]
            //     [
            //     $order => $request->input('product_id'),
            //     'user_id' => Auth::id(),
            //     'quantity' => $request->quantity,
            //     'address' => $request->address
            // ]
        );
 
            return response()->json([
                'status' => (bool) $order,
                'data'   => $order,
                'message' => $order ? 'Order Created!' : 'Error Creating Order'
            ]);
        }
 
        public function show(Order $order)
        {
            return response()->json($order,200);
        }
 
        public function update(Request $request, Order $order) //Updates the Order
        {
            $status = $order->update(
                $request->only(['quantity'])
            );
 
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Order Updated!' : 'Error Updating Order'
            ]);
        }
 
        public function destroy(Order $order)  //Deletes the Order
        {
            $status = $order->delete();
 
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
            ]);
        }
    }
