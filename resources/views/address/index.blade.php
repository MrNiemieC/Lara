@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Adresy</h2>
            </div>
            <div class="pull-right">
                @can('address-create')
                    <a class="btn btn-success" href="{{ route('address.create') }}">Stwórz nowy adres</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Lp</th>
            <th>Miasto</th>
            <th>Kod pocztowy</th>
            <th>Ulica</th>
            <th>Numer domu</th>
            <th>Numer mieszkania</th>
            <th width="280px">Opcje</th>
        </tr>
        @can('orders-filter-client')
            @php
                $address = $address->where('user_id', Auth::user()->id)
            @endphp
        @endcan
        @foreach ($address as $opt)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $opt->city }}</td>
                <td>{{ $opt->postal_code }}</td>
                <td>{{ $opt->street }}</td>
                <td>{{ $opt->house_number }}</td>
                <td>{{ $opt->apartment_number }}</td>
                <td>
                    <form action="{{ route('address.destroy',$opt->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('address.show',$opt->id) }}">Szczegóły</a>
                        @can('address-edit')
                            <a class="btn btn-primary" href="{{ route('address.edit',$opt->id) }}">Edytuj</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('address-delete')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
