<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Order as Order;
use Session;

class OrderController extends Controller
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

    public function index(Request $request)
    {
        $loggedUser = Auth::user()->id;
        $Order = $this->orderModel()->getOrders($loggedUser);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($Order['data']);
        $perPage = 10;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('order')->with(['orders' => $paginatedItems]);
    }

    public function orderConfirmation(){
        return view('orderconf')->with(['response' => Session::get('response')]);
    }
}
