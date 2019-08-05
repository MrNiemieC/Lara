@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Order</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('orders.store',['user'=>Auth::user()->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="inputAddress" class="col-sm-2 col-form-label"><strong>Select Address</strong></label>
                    <select id="inputAddress" class="form-control" name="selectAddress">
                        @if( DB::table('address')->where('user_id',Auth::user()->id)->first() )
                            @php
                                $address = DB::table('address')->where('user_id',Auth::user()->id)->get()
                            @endphp
                            <option selected>Choose...</option>
                            @foreach ($address as $options)
                                <option value="{{$options->id}}">
                                    {{$options->city.' '.$options->postal_code.' '.$options->street.' '.$options->house_number.'/'.$options->apartment_number}}
                                </option>
                            @endforeach
                        @else
                            <option>No address found add new and attach to order</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $details = DB::table('details');
                $products = \App\Product::all();
                $j = 0;
            @endphp
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $options)
                <tr>
                    <th scope="row">{{++$j}}</th>
                    <td>{{$options->name}}</td>
                    <td><input type="number" class="form-control" name="amount{{$options->name}}"></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    </form>
@endsection
