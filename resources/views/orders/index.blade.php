@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Orders Management</h2>
            </div>
            <div class="pull-right">
                @canany(['orders-filter-client','orders-filter-employee'])
                    <form action="{{ route('orders.index') }}">
                        <div class="form-row">
                            <div class="form-group col-md-auto">
                                <label for="inputFilter">Filter</label>
                            </div>
                            <div class="form-group col-md-auto">
                                <select id="inputFilter" class="form-control" name="filter">
                                    <option selected>Choose...</option>
                                    <option value="created_before">Created before</option>
                                    <option value="created_after">Created after</option>
                                    <option value="status">Status</option>
                                    @can('orders-filter-employee')
                                        <option value="client">Client</option>
                                    @endcan
                                </select>
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseDate">
                                <input type="date" class="form-control" id="inputDate" name="inputDate">
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseSelectClient">
                                <select id="inputData" class="form-control" name="selectClient">
                                    <option selected>Choose...</option>
                                    @foreach ($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseSelectStatus">
                                <select id="inputStatus" class="form-control" name="selectStatus">
                                    <option selected>Choose...</option>
                                    @foreach ($status as $options)
                                        <option value="{{$options->id}}">{{$options->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-auto">
                                <button type="submit" class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                @endcanany
            </div>
            <div class="pull-right">
                @can('orders-create')
                    <a class="btn btn-success" href="{{ route('orders.create') }}"> Create New Order</a>
                @endcan
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#inputFilter').change(function () {
                $("#inputFilter option:selected").each(function () {
                    if ($(this).attr("value") === "client") {
                        $("#collapseSelectClient").show();
                        $("#collapseSelectStatus").hide();
                        $("#collapseDate").hide();
                    } else if ($(this).attr("value") === "status") {
                        $("#collapseSelectClient").hide();
                        $("#collapseSelectStatus").show();
                        $("#collapseDate").hide();
                    } else if ($(this).attr("value") === "created_before" || $(this).attr("value") === "created_after") {
                        $("#collapseSelectClient").hide();
                        $("#collapseSelectStatus").hide();
                        $("#collapseDate").show();
                    } else {
                        $("#collapseSelectClient").hide();
                        $("#collapseSelectStatus").hide();
                        $("#collapseDate").hide();
                    }
                });
            });
        });
    </script>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Status</th>
            <th>Address</th>
            <th>@sortablelink('created_at','Created at')</th>
            <th>@sortablelink('updated_at','Updated at')</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $orders)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $orders->user_id }}</td>
                <td>{{ $orders->status_id }}</td>
                <td>{{ $orders->address_id }}</td>
                <td>{{ $orders->created_at }}</td>
                <td>{{ $orders->updated_at }}</td>
            </tr>
        @endforeach
    </table>


    {!! $data->render() !!}


@endsection
