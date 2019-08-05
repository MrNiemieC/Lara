<?php


namespace app\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StatusController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:status-list');
    }

    public function index(Request $request)
    {
        $data = Status::orderBy('id', 'DESC')->paginate(5);
        return view('status.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
