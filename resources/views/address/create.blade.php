@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tworzenie nowego adresu</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('address.index') }}"> Wstecz</a>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong>Napotkano problem z twoimi danymi.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('address.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Miasto:</strong>
                    <input type="text" name="city" class="form-control" placeholder="Miasto">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kod pocztowy:</strong>
                    <input type="text" name="postal_code" class="form-control" placeholder="00-000">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Ulica</strong>
                    <input type="text" name="street" class="form-control" placeholder="Ulica">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Numer domu:</strong>
                    <input type="text" name="house_number" class="form-control" placeholder="15A">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Numer mieszkania:</strong>
                    <input type="text" name="apartment_number" class="form-control" placeholder="5">
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Wyślij</button>
            </div>
        </div>
    </form>
@endsection
