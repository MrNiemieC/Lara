@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Szczegóły zamówienia</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}">Wstecz</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                {{ $order->Status->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Adres:</strong>
                @if ($order->Address->apartment_number == '')
                    <td>{{ $order->Address->city.' '.$order->Address->postal_code.' '.
                $order->Address->street.' '.$order->Address->house_number}}</td>
                @else
                    <td>{{ $order->Address->city.' '.$order->Address->postal_code.' '.
                $order->Address->street.' '.$order->Address->house_number.'/'.
                $order->Address->apartment_number}}</td>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Utworzono:</strong>
                {{ $order->created_at }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Zmodyfikowano:</strong>
                {{ $order->updated_at }}
            </div>
        </div>
    </div>
    <div class="row">
        <strong>Szczegóły:</strong>
        @php
            $j = 0;
        @endphp
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Lp</th>
                <th scope="col">Produkt</th>
                <th scope="col">Ilość</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->Product as $options)
                <tr>
                    <th scope="row">{{++$j}}</th>
                    <td>{{$options->name}}</td>
                    <td>{{$options->pivot->amount}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
