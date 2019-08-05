<?php


namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list');
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::sortable()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nazwa jest wymagana do utworzenia produktu',
            'detail.required' => 'Opis jest wymagany do utowrzenia produktu',
        ];
        $validate_array = [
            'name' => 'required',
            'detail' => 'required',
        ];
        $this->validate($request, $validate_array, $messages);
        Product::create($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Produkt utworzony pomyślnie.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $messages = [
            'name.required' => 'Nazwa jest wymagana do zaktualizowania produktu',
            'detail.required' => 'Opis jest wymagany do zaktualizowania produktu',
        ];
        $validate_array = [
            'name' => 'required',
            'detail' => 'required',
        ];
        $this->validate($request, $validate_array, $messages);
        $product->update($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Produkt zaktualizowany pomyślnie');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produkt usunięty pomyślnie');
    }
}
