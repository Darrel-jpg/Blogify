<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->slug === 'uncategorized') {
            return redirect()->back()
                ->with('error', 'Cannot delete the default category.');
        }

        $defaultCategory = Category::firstOrCreate(['name' => 'Uncategorized', 'slug' => 'uncategorized', 'color' => 'blue']);
        $postsCount = $category->posts()->count();
        
        if ($postsCount > 0) {
            $category->posts()->update(['category_id' => $defaultCategory->id]);
        }
        
        $category->delete();
        
        if ($postsCount > 0) {
            return redirect()->route('admin.posts')
                ->with('success', "Category deleted successfully! {$postsCount} post(s) moved to 'Uncategorized'.");
        } else {
            return redirect()->route('admin.posts')
                ->with('success', 'Category deleted successfully!');
        }
    }
}
