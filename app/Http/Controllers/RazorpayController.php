<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
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

    public function createOrder(Request $request)
    {
        try {
            $order = $this->razorpay->order->create([
                'amount' => $request->amount,
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
        $success = false;
        
        try {
            $attributes = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            
            $this->razorpay->utility->verifyPaymentSignature($attributes);
            $success = true;
        } catch (\Exception $e) {
            $success = false;
        }

        return response()->json([
            'success' => $success
        ]);
    }
}
