<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);

        return view('pages.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('pages.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories',
        ]);

        //nama yang masuk huruf awal otoamatis jadi huruf besar
        $request['name'] = ucwords($request['name']);

        Category::create($request->all());

        return redirect()->route('category.index')->with('success', 'Category successfully created');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories,name,' . $category->id,
        ]);
        //nama yang masuk huruf awal otoamatis jadi huruf besar
        $request['name'] = ucwords($request['name']);

        $category->update($request->all());

        return redirect()->route('category.index')->with('success', 'Category successfully updated');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category successfully deleted');
    }
}
