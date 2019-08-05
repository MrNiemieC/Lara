@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Zamówienia</h2>
            </div>
            <div class="pull-right">
                @canany(['orders-filter-client','orders-filter-employee'])
                    <form action="{{ route('orders.index') }}">
                        <div class="form-row">
                            <div class="form-group col-md-auto">
                                <label for="inputFilter">Filtruj</label>
                            </div>
                            <div class="form-group col-md-auto">
                                <select id="inputFilter" class="form-control" name="filter">
                                    <option selected>Wybierz...</option>
                                    <option value="created_before">Utworzono przed</option>
                                    <option value="created_after">Utworzono po</option>
                                    <option value="status">Status</option>
                                    @can('orders-filter-employee')
                                        <option value="client">Klient</option>
                                    @endcan
                                </select>
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseDate">
                                <input type="date" class="form-control" id="inputDate" name="inputDate">
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseSelectClient">
                                <select id="inputData" class="form-control" name="selectClient">
                                    <option selected>Wybierz...</option>
                                    @foreach ($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-auto collapse" id="collapseSelectStatus">
                                <select id="inputStatus" class="form-control" name="selectStatus">
                                    <option selected>Wybierz...</option>
                                    @foreach ($status as $options)
                                        <option value="{{$options->id}}">{{$options->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-auto">
                                <button type="submit" class="btn btn-success">Szukaj</button>
                            </div>
                        </div>
                    </form>
                @endcanany
            </div>
            <div class="pull-right">
                @can('orders-create')
                    <a class="btn btn-success" href="{{ route('orders.create') }}">Stwórz nowe zamówienie</a>
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
            <th>Lp</th>
            <th>Użytkownik</th>
            <th>Status</th>
            <th>Adres</th>
            <th>@sortablelink('created_at','Stworzono')</th>
            <th>@sortablelink('updated_at','Zmodyfikowano')</th>
            <th width="280px">Opcje</th>
        </tr>
        @can('orders-filter-client')
            @php
                $data = $data->where('user_id', Auth::user()->id)
            @endphp
        @endcan
        @foreach ($data as $key => $orders)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $orders->User->name }}</td>
                <td>{{ $orders->Status->name }}</td>
                @if ($orders->Address->apartment_number == '')
                    <td>{{ $orders->Address->city.' '.$orders->Address->postal_code.' '.
                $orders->Address->street.' '.$orders->Address->house_number}}</td>
                @else
                    <td>{{ $orders->Address->city.' '.$orders->Address->postal_code.' '.
                $orders->Address->street.' '.$orders->Address->house_number.'/'.
                $orders->Address->apartment_number}}</td>
                @endif
                <td>{{ $orders->created_at }}</td>
                <td>{{ $orders->updated_at }}</td>
                <td>
                    <form action="{{ route('orders.destroy',$orders->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('orders.show',$orders->id) }}">Szczegóły</a>
                        @can('orders-edit')
                            @cannot('orders-status')
                                <a class="btn btn-primary" href="{{ route('orders.edit',$orders->id) }}">Edytuj</a>
                            @endcannot
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('orders-delete')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        @endcan
                    </form>
                    @can('orders-status')
                        <form action="{{ route('orders.update',$orders->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary" type="submit" name="submit" value="Confirm">Akceptuj
                            </button>
                            <button class="btn btn-primary" type="submit" name="submit" value="Deny">Odrzuć</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
@endsection
