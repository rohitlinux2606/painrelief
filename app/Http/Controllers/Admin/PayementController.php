<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayementController extends Controller
{
    /**
     * Cash on delivery
     */
    public function cod(Request $request)
    {
        try {
            $payment_method = paymentMethods($request->paymentMethod);

            $order = Order::find($request->order_id);
            $order->payment_status = 'Unpaid';
            $order->payment_method = 'Cash on delivery';
            $order->status = 'pending';
            $order->save();

            $method = 'Cash on delivery';
            $transaction_id = null;
            $status = 'pending';
            $amount = $order->total;
            $currency = 'INR';
            $payment_status = 'Unpaid';
            $payment_response = null;
            $payment_date = now();
            $payment_expiry = null;
            $payment_type = 'cod';
            $payment_mode = 'cod';
            $bank = null;
            $card_no = null;
            $card_type = null;
            $card_expiry_month = null;
            $card_expiry_year = null;
            $card_holder_name = null;

            // save payment details
            // save payment details
            $payment = new Payment;
            $payment->customer_id = $order->customer_id;
            $payment->order_id = $order->id;
            $payment->payment_method = $method;
            $payment->transaction_id = $transaction_id;
            $payment->status = $status;
            $payment->amount = $amount;
            $payment->currency = $currency;
            $payment->payment_status = $payment_status;
            $payment->payment_response = $payment_response;
            $payment->payment_date = $payment_date;
            $payment->payment_expiry = $payment_expiry;
            $payment->payment_type = $payment_type;
            $payment->payment_mode = $payment_mode;
            $payment->bank = $bank;
            $payment->card_no = $card_no;
            $payment->card_type = $card_type;
            $payment->card_expiry_month = $card_expiry_month;
            $payment->card_expiry_year = $card_expiry_year;
            $payment->card_holder_name = $card_holder_name;
            $payment->save();

            // $order = Order::find($request->order_id);
            $myorder = Order::with('items')->where('id', $order->id)->first();
            // Log::info($myorder->items);
            if ($myorder) {
                $this->updateStock($myorder->items);
            }

            $this->orderConfirmation($order);

            return redirect()->route('order-success', $order->order_number);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cashfree payment
     */
    public function cashFree(Request $request)
    {
        try {
            Log::info($request->all());
            Log::info(env('CASHFREE_API_KEY'));
            Log::info(env('CASHFREE_API_SECRET'));

            // Use cached config values to avoid env() lookups in runtime code (config cache safe)
            $apiKey = config('cashfree.api_key');
            $apiSecret = config('cashfree.api_secret');
            $cashfreeApiUrl = rtrim(config('cashfree.api_url'), '/');

            Log::info('Cashfree API Key: ' . $apiKey);
            Log::info('Cashfree API Secret: ' . $apiSecret);
            Log::info('Cashfree API URL: ' . $cashfreeApiUrl);

            $validated = $request->validate([
                'name' => 'required|min:3',
                'email' => 'nullable',
                'mobile' => 'required',
                'amount' => 'required',
            ]);

            $order = Order::find($request->order_id);
            if (! $order) {
                return redirect()->back()->with('error', 'Order not found');
            }

            $amount = $order->total;

            // // Use config values (config cache safe) for API endpoint and credentials
            // $url = $cashfreeApiUrl . '/orders';

            // $url = 'https://api.cashfree.com/pg/orders'; // Prodction Mode
            $url = 'https://sandbox.cashfree.com/pg/orders'; // for devlopement mode

            $headers = [
                'Content-Type' => 'application/json',
                'x-api-version' => '2022-01-01',
                'x-client-id' => $apiKey,
                'x-client-secret' => $apiSecret,
            ];

            $data = [
                'order_id' => $request->order_number,
                // 'order_amount' => $validated['amount'],
                'order_amount' => $amount,
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => $request->customer_id,
                    'customer_name' => $validated['name'],
                    'customer_email' => $validated['email'] ?? '',
                    'customer_phone' => $validated['mobile'],
                ],
                'order_meta' => [
                    // "return_url" => env('APP_URL') . '/order-detail/order_id=' . $request->order_number . '&status=success&payment_method=cash_free&order_number=' . $request->order_id

                    'return_url' => rtrim(config('app.url'), '/') . '/order-success/' . $request->order_number,
                ],
            ];

            $response = Http::withHeaders($headers)->post($url, $data);

            Log::info($response->json());
            // Log::info($response['order_id']);

            if ($response->json('order_status') == 'ACTIVE') {
                $order->payment_status = 'PAID';
                $order->payment_method = 'Online payment';
                $order->status = 'paid';
                $order->save();

                $method = 'Cashfree';
                $transaction_id = $response->json('order_token');
                $status = $response->json('order_status');
                $amount = $order->total;
                $currency = 'INR';
                $payment_status = $response->json('order_status');
                $payment_response = $response->json('order_token');
                $payment_date = now();
                $payment_expiry = null;
                $payment_type = 'online';
                $payment_mode = 'online';

                $this->orderConfirmation($order);

                // save payment details
                $payment = new Payment;
                $payment->customer_id = $order->customer_id;
                $payment->order_id = $order->id;
                $payment->payment_method = $method;
                $payment->transaction_id = $transaction_id;
                $payment->status = $status;
                $payment->amount = $amount;
                $payment->currency = $currency;
                $payment->payment_status = $payment_status;
                $payment->payment_response = $payment_response;
                $payment->payment_date = $payment_date;
                $payment->payment_expiry = $payment_expiry;
                $payment->payment_type = $payment_type;
                $payment->payment_mode = $payment_mode;
                $payment->bank = null;
                $payment->card_no = null;
                $payment->card_type = null;
                $payment->card_expiry_month = null;
                $payment->card_expiry_year = null;
                $payment->card_holder_name = null;
                $payment->save();
            } else {
                return redirect()->back()->with('error', $response->json('reason'));
            }

            $paymentLink = $response->json('payment_link');
            // Log::info($paymentLink);

            // Order total is natively calculated during initialization

            return redirect()->to($paymentLink);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * order confirmation message
     */
    private function orderConfirmation($order)
    {
        $customer = $order->customer;

        // empty cart session
        session()->forget('cart');

        // delete cart items from database
        $userId = Auth::id();
        $sessionId = session('cart_session') ?? session()->getId();

        Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->delete();

        // update stock
        if ($order) {
            $this->updateStock($order->items);
        }

        $address = $order->address;
        $data = [
            'name' => is_numeric($customer->name) ? ($address ? $address->name : '') : $customer->name,
            'order_number' => $order->order_number,
            'email' => $customer->email ?? ($address ? $address->email : ''),
            'total' => $order->total,
            'address' => $address,
        ];

        $today = Carbon::today();
        $delivery_date = $today->addDays(5)->format('Y-m-d');
        $phone = $address ? $address->phone : $customer->phone;
        $email = $address ? $address->email : $customer->email;

        // Sms
        $message = 'Dear ' . $data['name'] . ', Thank you for your order with Shrivenu Naturals! Your order #' . $data['order_number'] . ' is confirmed and will be delivered date ' . $delivery_date . '. We appreciate your trust in Shrivenu Naturals! Warm regards, Shrivenu Naturals';
        // $result = sendSms($phone, $message);
        // if ($result != 'sent') {
        //     throw new Exception('Failed to send SMS.');
        // }

        if ($email != null || $email != '') {
            // Mail
            $subject = 'Your Order with Shrivenu Naturals – confirmation';
            Mail::send('ecom.web.mails.orderMail', ['data' => $data], function ($message) use ($data, $subject) {
                $message->to($data['email'], $data['name'])->subject($subject);
            });
        }
    }

    /**
     * Summary of updateStock
     *
     * @param  mixed  $productItems
     * @return void
     */
    public function updateStock($productItems)
    {
        // Log::info($productItems);
        if ($productItems) {
            foreach ($productItems as $item) {
                $variant = Product::find($item->product_id);
                if ($variant != null) {
                    $stockQuantity = (int) $variant->stock_quantity - (int) $item->quantity;
                    $variant->stock_quantity = $stockQuantity;
                    $variant->save();
                }
            }
        }
    }
}
