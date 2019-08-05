@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Statusy</h2>
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
            <th>Nazwa</th>
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
