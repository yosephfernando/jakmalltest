<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Order as Order;

class PaymentController extends Controller
{
    private $OrderData;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function orderModel(){
        $this->OrderData = new Order();
        return $this->OrderData;
    }

    public function index($order_number)
    {
        return view('payment')->with(["order_number" => $order_number]);
    }

    public function payment()
    {
        return view('payment')->with(["order_number" => null]);
    }

    public function paymentAction(Request $request)
    {
        $this->orderModel()->updateOrder($request->ordernumber);
        return Redirect::route('order');
    }
}
