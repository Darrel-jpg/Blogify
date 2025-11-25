<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function posts()
    {
        $title = 'Manage Posts';
        $header = 'Post Management';
        $posts = Post::latest()->filter(request(['search', 'category', 'author']))->paginate(10)->withQueryString();
        $categories = Category::all();
        $totalAuthors = $users = User::has('posts')->count();

        return view('manage-posts', compact('title', 'header', 'posts', 'categories', 'totalAuthors'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
