@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Orders</div>

                <div class="card-body">
                   <div>
                        <table style="width:100%">
                                <tr style="font-weight:bold">
                                    <td>Order No.</td>
                                    <td>Description</td>
                                    <td>Total</td>
                                    <td>Information</td>
                                </tr>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order['order_number']}}</td>
                                        <td>{!! $order['description'] !!}</td>
                                        <td>{{$order['total']}}</td>
                                        <td>{!! $order['information'] !!}</td>
                                    </tr>
                                @endforeach
                        </table>
                   </div>
                   <div style="margin-top:10px;float:right">
                        {{ $orders->links() }}
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
