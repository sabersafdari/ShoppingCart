<?php

namespace App\Http\Controllers\Website;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;


class OrderController extends WebsiteController
{
    public function addToCart(Product $product, Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addToCart($product);
        $request->session()->put('cart', $cart);

        if (!is_null($request->ajax))
            return response()->json([
                'count' => $cart->count
            ]);
        else
            return back();    }

    public function removeFromCart(Product $product, Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeFromCart($product);
        $request->session()->put('cart', $cart);

        return back();
    }

    public function updateCart(Product $product, Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateCart($product, $request->count);
        $request->session()->put('cart', $cart);

        return back();
    }

    public function cartShow(Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);

        return view('website.order.cart', compact('cart'));
    }

    public function addAddress(Request $request)
    {
        //ابتدا اعتبار سنجی
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->setAddress($request->adderss);

        return redirect(route('invoice'));
    }

    public function invoice(Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->setAddress($request->adderss);
        $request->session()->put('cart', $cart);

        return view('website.order.invoice', compact('cart'));
    }

    public function store(Request $request)
    {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);

        //نیاز به اعتبارسنجی داده های

        //برای مقداردهی ویژگی های سفارش
        $order = auth()->user()->orders()->create([
            'price' => $cart->price,
            'address' => $cart->address
        ]);

        //برای مقداردهی ویژگی های سفارش
        foreach ($cart->products as $item) {
            $product = $item['product'];
            $order->products()->attach([
                $product->id => [
                    'count' => $item['count'],
                    'price' => $item['price'],
                ]
            ]);
        }

        $invoice = new Invoice;
        $invoice->amount($order->price);
        return Payment::callbackUrl(route('payResult'))->purchase(
            $invoice,
            function ($driver, $transactionId) use ($order) {
                // We can store $transactionId in database.
                $order->update([
                    'transaction_id' => $transactionId
                ]);
            }
        )->pay()->render();
    }

    public function payResult(Request $request)
    {
        $transaction_id = $request->Authority;
        $order = Order::where('transaction_id', $transaction_id)->first();

        if (is_null($order))
            abort(404);

        try {
            $receipt = Payment::amount($order->price)->transactionId($transaction_id)->verify();
            $order->update([
                'reference_id' => $order->getReferenceId(),
                'status' => 'payed'
            ]);
            $request->session()->remove('cart');
            dd('ممنون از خرید شما!');
            // You can show payment referenceId to the user.
//            echo $receipt->getReferenceId();
        } catch (InvalidPaymentException $exception) {
            dd($exception->getMessage());
//            echo $exception->getMessage();
        }
    }
}
