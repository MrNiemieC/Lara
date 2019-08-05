<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users-list');
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nazwa jest wymagana do utworzenia użytkownika',
            'email.required' => 'Email jest wymagany do utworzenia użytkownika',
            'email.email' => 'Email nie posiada poprawnego formatu mailowego',
            'email.unique' => 'Email jest już w użyciu',
            'password.required' => 'Hasło jest wymagane do utowrzenia użytkownika',
            'password.same' => 'Oba hasła muszą być zgodne',
            'roles.required' => 'Rola jest wymagana do utworzenia użytkownika',
        ];
        $validate_array = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ];
        $this->validate($request, $validate_array, $messages);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Użytkownik utworzony pomyślnie');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'Nazwa jest wymagana do zaktualizowania użytkownika',
            'email.required' => 'Email jest wymagany do zaktualizowania użytkownika',
            'email.email' => 'Email nie posiada poprawnego formatu mailowego',
            'email.unique' => 'Email jest już w użyciu',
            'password.required' => 'Hasło jest wymagane do zaktualizowania użytkownika',
            'password.same' => 'Oba hasła muszą być zgodne',
            'roles.required' => 'Rola jest wymagana do zaktualizowania użytkownika',
        ];
        $validate_array = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ];
        $this->validate($request, $validate_array, $messages);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Użytkownik utworzony pomyślnie');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'Użytkownik usunięty pomyślnie');
    }
}
