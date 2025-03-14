<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );
    }

    public function getPrice()
    {
        $priceObject = DB::table('settings')->select('price')->first();

        if ($priceObject) {
            return (int) $priceObject->price;
        } else {
            return 0;
        }
    }

    public function createOrder(Request $request)
    {
        $price = $this->getPrice();

        try {
            $order = $this->razorpay->order->create([
                'amount' => $price * 100,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $request->amount
            ]);
        } catch (Exception $e) {

            Log::error('Razorpay Order Creation Failed: ' . $e->getMessage());

            // Return an error response to the client
            return response()->json([
                'message' => 'Order creation failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        Log::debug("Received request data in verifyPayment: ", $request->all());

        try {
            $attributes = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            $order = $this->razorpay->order->fetch($request->razorpay_order_id);

            return response()->json([
                'success' => true,
                'showModal' => true,
                'message' => 'Payment successful!'
            ]);
        } catch (\Exception $e) {
            Log::error("Razorpay Payment Verification Failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'showModal' => false,
                'message' => 'Payment verification failed'
            ]);
        }
    }

    public function storePaymentDetails(Request $request) {}
}
