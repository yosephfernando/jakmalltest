@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product Commerce Form</div>

                <div class="card-body">
                   <form method="post">
                      @csrf
                      <div>
                        <label style="vertical-align: top;">Product: </label>
                        <textarea name="product">{{old('product')}}</textarea>
                        {!! $errors->first('product', '<p class="alert alert-danger">:message</p>') !!}
                      </div>
                      <div>
                        <label style="vertical-align: top;">Shipping address: </label>
                        <textarea name="shipping_address">{{old('shipping_address')}}</textarea>
                        {!! $errors->first('shipping_address', '<p class="alert alert-danger">:message</p>') !!}
                      </div>
                      <div>
                        <label>Price: </label>
                        <input type="text" name="price" value="{{old('price')}}" />
                        {!! $errors->first('price', '<p class="alert alert-danger">:message</p>') !!}
                      </div>
                      <div>
                        <button type="submit">Submit</button>
                      </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
