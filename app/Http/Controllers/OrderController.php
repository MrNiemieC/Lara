<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Status;
use App\User;
use App\Http\Controllers\Controller;
use DB;

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
                $data = Order::sortable()->where('created_at','<',$request->inputDate)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            } elseif ($request->filter === 'created_after') {
                $data = Order::sortable()->where('user_id','>',$request->inputDate)->paginate(5);
                return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                    ->with('i', ($request->input('page', 1) - 1) * 5);
            }
        } else {
            $data = Order::sortable()->paginate(5);
            return view('orders.index', compact('data'), ['status' => $status, 'clients' => $clients])
                ->with('i', ($request->input('page', 1) - 1) * 5);
        };
    }

}
