@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Produkty</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                    <a class="btn btn-success" href="{{ route('products.create') }}">Stwórz nowy produkt</a>
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
            <th>@sortablelink('name','Nazwa')</th>
            <th>Opis</th>
            <th width="280px">Opcje</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->detail }}</td>
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Szczegóły</a>
                        @can('product-edit')
                            <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edytuj</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('product-delete')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $products->links() !!}
@endsection
