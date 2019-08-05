@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edycja adresu</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('address.index') }}"> Wstecz</a>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong>Napotkano problemy z twoimi danymi.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('address.update',$address->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Miasto:</strong>
                    <input type="text" name="City" class="form-control" value="{{ $address->city }}"
                           placeholder="Miasto">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kod pocztowy:</strong>
                    <input type="text" name="postal_code" class="form-control" value="{{ $address->postal_code }}"
                           placeholder="00-000">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Ulica</strong>
                    <input type="text" name="street" class="form-control" value="{{ $address->street }}"
                           placeholder="Ulica">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Numer domu:</strong>
                    <input type="text" name="house_number" class="form-control" value="{{ $address->house_number }}"
                           placeholder="15A">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Numer mieszkania:</strong>
                    <input type="text" name="apartment_number" class="form-control"
                           value="{{ $address->apartment_number }}" placeholder="5">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Wyślij</button>
            </div>
        </div>
    </form>
@endsection
