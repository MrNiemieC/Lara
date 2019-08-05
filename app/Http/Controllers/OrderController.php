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
        $this->middleware('permission:orders-filter-employee', ['only' => ['filter']]);
        $this->middleware('permission:orders-filter-client', ['only' => ['filter']]);
    }

    public function index(Request $request)
    {
        $status = Status::all();
        $clients = DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', '=', 2);
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
                $data = Order::sortable()->where('created_at', '<', $request->inputDate)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            } elseif ($request->filter === 'created_after') {
                $data = Order::sortable()->where('user_id', '>', $request->inputDate)->paginate(5);
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
            'selectAddress.integer' => 'Create address first before order',
            'required_without_all'  => 'Choose at least one amount , all amounts empty',
        ];
        $product = Product::all();
        $validate_array = [ 'selectAddress' => 'required|integer'];
        foreach ($product as $options) {
            $string = '';
            foreach ($product as $opt) {
                if ($opt->name != $options->name) $string = $string . 'amount' . $opt->name . ',';
            }
            $validate_array['amount' . $options->name] = 'required_without_all:' . $string;
        }
        $this->validate($request, $validate_array,$messages);

        $order = new Order;
        $input = Input::get();
        foreach ($input as $name => $value)
            foreach ($product as $opt) {
                if ($name == 'amount' . $opt->name and $value > 0) {
                    $detail= new Detail;
                    $detail->product_id = $opt->id;
                    $detail->amount = $value;
                    $detail->save();
                    $order->details_id=$detail->id;
                }
            }
            $order->user_id = $request->user;
            $order->status_id = 1;
            if ($request->selectAddress > 0 and $request->selectAddress->notNull()) $order->address_id=$request->selectAddress; else $order->address_id=null;
            $order->push();


        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

}
