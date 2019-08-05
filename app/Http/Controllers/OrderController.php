<?php


namespace App\Http\Controllers;

use App\Detail;
use Illuminate\Http\Request;
use App\Order;
use App\Status;
use App\User;
use App\Http\Controllers\Controller;
use DB;
use App\Product;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:orders-list');
        $this->middleware('permission:orders-status', ['only' => ['confirm', 'deny']]);
        $this->middleware('permission:orders-filter-employee', ['only' => ['filter']]);
        $this->middleware('permission:orders-filter-client', ['only' => ['filter']]);
        $this->middleware('permission:orders-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:orders-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:orders-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $status = Status::all();
        $clients = DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', '=', 3);
            })->get();
        if ($request->has('filter')) {
            if ($request->filter === 'status') {
                $data = Order::sortable()->where('status_id', $request->selectStatus)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            } elseif ($request->filter === 'client') {
                $data = Order::sortable()->where('user_id', $request->selectClient)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            } elseif ($request->filter === 'created_before') {
                $data = Order::sortable()->where('created_at', '<=', $request->inputDate)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            } elseif ($request->filter === 'created_after') {
                $data = Order::sortable()->where('created_at', '>=', $request->inputDate)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            }
        } else {
            $data = Order::sortable()->paginate(5);
            return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                ->with('i', ($request->input('page', 1) - 1) * 5);
        };
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'selectAddress.integer' => 'Stwórz adres przed złożeniem zamówienia',
            'required_without_all' => 'Ilość nie może być pusta',
        ];
        $product = Product::all();
        $validate_array = ['selectAddress' => 'required|integer'];
        foreach ($product as $options) {
            $string = '';
            foreach ($product as $opt) {
                if ($opt->name != $options->name) $string = $string . 'amount' . $opt->name . ',';
            }
            $validate_array['amount' . $options->name] = 'required_without_all:' . $string;
        }
        $this->validate($request, $validate_array, $messages);
        $order = new Order;
        $order->user_id = $request->user;
        $order->status_id = 1;
        if ($request->selectAddress !== '') $order->address_id = $request->selectAddress; else $order->address_id = null;
        $order->push();
        $input = Input::get();
        foreach ($input as $name => $value)
            foreach ($product as $opt) {
                if ($name == 'amount' . $opt->name and $value > 0) {
                    $detail = new Detail;
                    $detail->product_id = $opt->id;
                    $detail->order_id = $order->id;
                    $detail->amount = $value;
                    $detail->save();
                }
            }

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie utworzone pomyślnie.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($request->submit === 'Confirm') {
            Order::where('id', '=', $order->id)
                ->update(['status_id' => 3]);
        } elseif ($request->submit === 'Deny') {
            Order::where('id', '=', $order->id)
                ->update(['status_id' => 2]);
        } else {
            $messages = [
                'selectAddress.integer' => 'Wybierz adres żeby zaktualizować zamówienie',
            ];
            $validate_array = ['selectAddress' => 'required|integer'];
            $this->validate($request, $validate_array, $messages);
            $order->update(['address_id' => $request->selectAddress]);
        }
        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie zaktualizowano pomyślnie');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie usunięto pomyślnie');
    }
}
