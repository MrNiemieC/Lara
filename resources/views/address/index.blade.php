@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Address</h2>
            </div>
            <div class="pull-right">
                @can('address-create')
                    <a class="btn btn-success" href="{{ route('address.create') }}"> Create New address</a>
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
            <th>@sortablelink(No)</th>
            <th>City</th>
            <th>Postal code</th>
            <th>Street</th>
            <th>House Number</th>
            <th>Apartment Number</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($Address as $opt)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $opt->city }}</td>
                <td>{{ $opt->postal_code }}</td>
                <td>{{ $opt->street }}</td>
                <td>{{ $opt->house_number }}</td>
                <td>{{ $opt->apartment_number }}</td>
                <td>
                    <form action="{{ route('address.destroy',$address->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('address.show',$address->id) }}">Show</a>
                        @can('address-edit')
                            <a class="btn btn-primary" href="{{ route('address.edit',$address->id) }}">Edit</a>
                        @endcan


                        @csrf
                        @method('DELETE')
                        @can('address-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>


    {!! $address->links() !!}


@endsection
