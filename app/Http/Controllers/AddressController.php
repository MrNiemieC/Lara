<?php


namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:address-list');
        $this->middleware('permission:address-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:address-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:address-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $address = Address::sortable()->paginate(5);
        return view('address.index', compact('address'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'city.required' => 'Miasto jest wymagane do utworzenia adresu',
            'postal_code.required' => 'Kod pocztowy jest wymagany do utworzenia adresu',
            'street.required' => 'Ulica jest wymagana do utworzenia adresu',
            'house_number.required' => 'Numer domu jest wymagany do utworzenia adresu',
        ];
        $validate_array = [
            'city' => 'required',
            'postal_code' => 'required',
            'street' => 'required',
            'house_number' => 'required',
        ];
        $this->validate($request, $validate_array, $messages);
        Address::create($request->all());
        return redirect()->route('address.index')
            ->with('success', 'Adres stworzony pomyślnie.');
    }

    public function show(Address $address)
    {
        return view('address.show', compact('address'));
    }

    public function edit(Address $address)
    {
        return view('address.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $messages = [
            'city.required' => 'Miasto jest wymagane do zaktualizowania adresu',
            'postal_code.required' => 'Kod pocztowy jest wymagany do zaktualizowania adresu',
            'street.required' => 'Ulica jest wymagana do zaktualizowania adresu',
            'house_number.required' => 'Numer domu jest wymagany do zaktualizowania adresu',
        ];
        $validate_array = [
            'city' => 'required',
            'postal_code' => 'required',
            'street' => 'required',
            'house_number' => 'required',
        ];
        $this->validate($request, $validate_array, $messages);
        $address->update($request->all());
        return redirect()->route('address.index')
            ->with('success', 'Adres zaktualizowano pomyślnie');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('address.index')
            ->with('success', 'Adres usunięty pomyślnie');
    }
}
