<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Order as Order;
use App\Prepaid as Prepaid;
use App\Rules\Prefixmobile as Prefixmobile;

class PrepaidController extends Controller
{
    private $OrderModel;
    private $PrepaidModel;
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
        $this->OrderModel = new Order();
        return $this->OrderModel;
    }

    private function prepaidModel(){
        $this->PrepaidModel = new Prepaid();
        return $this->PrepaidModel;
    } 

    public function index()
    {
        return view('prepaid');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'mobile_phone' => new Prefixmobile(),
            'value' => 'required',
        ]);

        $dataPrepaidToSave = $request->except(['_token']);
        $dataPrepaidToSave['status'] = "";

        $createdPrepaidId = $this->prepaidModel()->createPrepaid($dataPrepaidToSave);

        $dataOrderToSave = [
            "bussinesstypetable_type" => "App\Prepaid",
            "bussinesstypetable_id" => $createdPrepaidId,
            "custommer_id" => Auth::user()->id
        ];

        $createdOrder = $this->orderModel()->createOrder($dataOrderToSave, $dataPrepaidToSave);
        return Redirect::route('order-confirmation')->with(['response' => $createdOrder]);
    }
}
