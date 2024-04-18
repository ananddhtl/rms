<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\OrderResource;

class OrderApiController extends BaseApiController
{
    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            $cart = Cart::findOrFail($request->cart_id);

            if (!$cart || $cart->cart_total <= 0) {
                return $this->sendError('Cart is empty or invalid');
            }

            $salesTotal = $cart->cart_total;
            $discount = 0;
            $grandTotal = $salesTotal - $discount;

            $order = Order::create([
                'user_id' => auth('api')->user()->id,
                'table_id' => $request->table_id,
                'reference_id' => $request->reference_id,
                'order_type' => $request->order_type,
                'sales_total' => $salesTotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
            ]);

            $cart_items = CartItem::where('cart_id', $cart->id)->get();

            foreach ($cart_items as $cart_item) {
                $product = Product::find($cart_item->product_id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_item->product_id,
                    'quantity' => $cart_item->quantity,
                    'price' =>  $product->price,
                    'total' => $cart_item->quantity * $product->price,
                ]);
            }

            $cart->delete();

            DB::commit();

            $order = $order->fresh(['items', 'table', 'items.product', 'items.product.image']);

            return $this->sendResponse($order, 'Order placed successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Something went wrong');
        }
    }

    public function getOrders()
    {
        try {
            $orders = Order::where('user_id', auth('api')->user()->id)->with('items', 'table', 'items.product', 'items.product.image')->latest()->get();

            return $this->sendResponse(OrderResource::collection($orders), "User's all orders");
        } catch (Exception $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function getOrderById(Request $request)
    {
        try {
            $order = Order::where('id', $request->id)->with('items', 'table', 'items.product', 'items.product.image')->first();
            if ($order) {
                return $this->sendResponse(new OrderResource($order), "Order details");
            } else {
                return $this->sendError('Order not found.');
            }
        } catch (Exception $e) {
            return $this->sendError('Something went wrong');
        }
    }
}
