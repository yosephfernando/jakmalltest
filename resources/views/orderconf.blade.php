@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order Confirmation</div>

                <div class="card-body" style="text-align:center">
                   <h3>Your Order Number</h3>
                   <strong>{{$response['ordernumber']}}</strong>
                   <p>Total</p>
                   <p>{{ number_format($response['total']) }}</p>
                   <p>{{ $response['description'] }}</p>
                   <a href="{{url('/payment')}}/{{$response['ordernumber']}}"><button>Pay here</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
