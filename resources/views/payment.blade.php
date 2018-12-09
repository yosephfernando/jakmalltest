@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment</div>

                <div class="card-body">
                   <form method="post" action="{{route('paymentsubmit')}}">
                      @csrf
                      <div>
                        <label>Order Number: </label>
                        <input type="number" name="ordernumber" value={{ $order_number }} />
                      </div>
                      <div>
                        <button type="submit">Pay</button>
                      </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
