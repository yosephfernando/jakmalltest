@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Prepaid Balance Form</div>

                <div class="card-body">
                   <form method="post">
                     @csrf
                      <div>
                        <label>Mobile Phone Number: </label>
                        <input type="text" name="mobile_phone" value="{{old('mobile_phone')}}" />
                        {!! $errors->first('mobile_phone', '<p class="alert alert-danger">:message</p>') !!}
                      </div>
                      <div>
                        <label>Value: </label>
                        <select name="value">
                            <option value="">-- Select value --</option>
                            <option value="10000" {{ old('value') == 10000 ? 'selected' : '' }}>10.000</option>
                            <option value="50000" {{ old('value') == 50000 ? 'selected' : '' }}>50.000</option>
                            <option value="100000" {{ old('value') == 100000 ? 'selected' : '' }}>100.000</option>
                        </select>
                        {!! $errors->first('value', '<p class="alert alert-danger">:message</p>') !!}
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
