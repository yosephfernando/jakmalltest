<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Order as Order;
use App\Prodcomm as Prodcomm;

class ProductCommController extends Controller
{
    private $OrderModel;
    private $ProdcommModel;
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

    private function prodcommModel(){
        $this->ProdcommModel = new Prodcomm();
        return $this->ProdcommModel;
    } 

    public function index()
    {
        return view('product');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'product' => 'required',
            'shipping_address' => 'required',
            'price' => 'required|numeric',
        ]);

        $dataProdcommToSave = $request->except(['_token']);
        $dataProdcommToSave['status'] = "";
        $dataProdcommToSave['shipping_code'] = "";

        $createdProdcommId = $this->prodcommModel()->createProdcomm($dataProdcommToSave);

        $dataOrderToSave = [
            "bussinesstypetable_type" => "App\Prodcomm",
            "bussinesstypetable_id" => $createdProdcommId,
            "custommer_id" => Auth::user()->id
        ];

        $createdOrder = $this->orderModel()->createOrder($dataOrderToSave, $dataProdcommToSave);
        return Redirect::route('order-confirmation')->with(['response' => $createdOrder]);
    }
}
