<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        $category = \App\Models\Category::findOrFail($request->category);

        $product = new \App\Models\Product;
        $product->name = ucwords($request->name);
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $category->name; // Save category name instead of ID
        $product->image = $filename;
        $product->save();
        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products,name,' . $id,
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        $product = \App\Models\Product::findOrFail($id);

        $data = $request->all();
        $data['name'] = ucwords($data['name']);

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        $category = \App\Models\Category::findOrFail($request->category);
        $data['category'] = $category->name; // Save category name instead of ID

        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
