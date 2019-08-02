@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Status Management</h2>
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
            <th>No</th>
            <th>Name</th>
        </tr>
        @foreach ($data as $key => $status)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $status->name }}</td>
            </tr>
        @endforeach
    </table>


    {!! $data->render() !!}

@endsection
