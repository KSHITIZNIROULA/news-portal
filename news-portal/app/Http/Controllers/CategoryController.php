<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);
        try {
            Category::create($category);
            return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Failed to delete category' . $e->getMessage());
        }
    }
}



