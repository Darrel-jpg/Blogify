<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function posts()
    {
        $title = 'Blog';
        $header = 'All Posts';
        $sort = request('sort');
        $query = Post::filter(request(['search', 'category', 'author']));

        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most-commented':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'a-to-z':
                $query->orderBy('title', 'asc');
                break;
            case 'z-to-a':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
        }

        $posts = $query->paginate(9)->withQueryString();

        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            if ($category) {
                $header = 'Articles in ' . $category->name;
            }
        }

        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            if ($author) {
                $header = 'Articles by ' . $author->name;
            }
        }

        if (request('search')) {
            $header = 'Search results for "' . request('search') . '"';
        }

        return view('posts', compact('posts', 'title', 'header'));
    }

    public function post(Post $post)
    {
        $title = 'Blog';
        $header = 'All Post';
        $tab = 'Detail';
        return view('post', compact('post', 'title', 'header', 'tab'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'post_id'   => $post->id,
            'user_id'   => $request->user()->id,
            'content'   => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return back();
    }

    public function myBlog()
    {
        $title = 'My Blog';
        $header = 'My Blog';
        $sort = request('sort');
        $query = Post::filter(request(['search', 'category', 'author']))->where('author_id', auth()->id());

        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most-commented':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'a-to-z':
                $query->orderBy('title', 'asc');
                break;
            case 'z-to-a':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('posts', compact('posts', 'title', 'header'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function formPost(?Post $post = null)
    {
        $isEdit = $post !== null;

        $title = $isEdit ? 'Edit Post' : 'Create Post';
        $header = $isEdit ? 'Edit Post' : 'Create Post';

        $categories = Category::all();

        if ($isEdit && auth()->user()->role !== 'admin' && $post->author_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('form-post', compact('title', 'header', 'categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'category_id' => 'required',
            'content'     => 'required|min:5',
        ]);

        $slug = Str::slug($validated['title']);

        if (Post::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(1000, 9999);
        }

        if ($request->category_id === 'other') {
            $category = Category::create([
                'name' => $request->new_category,
                'slug' => Str::slug($request->new_category),
                'color' => 'lime',
            ]);

            $validated['category_id'] = $category->id;
        }

        // Simpan post
        Post::create([
            'title'       => $validated['title'],
            'slug'        => $slug,
            'author_id'   => $request->user()->id,
            'category_id' => $validated['category_id'],
            'content'     => $validated['content'],
        ]);

        return redirect()->route('posts')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->author_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        if ($validated['category_id'] === 'other') {

            $cat = $request->validate([
                'new_category' => 'required|min:2|max:100'
            ]);

            $category = Category::create([
                'name' => $cat['new_category'],
                'slug' => Str::slug($cat['new_category']),
                'color' => 'lime',
            ]);

            $validated['category_id'] = $category->id;
        }

        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('post', $post->slug)->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();
        return redirect()->route('posts')->with('success', 'Post deleted successfully!');
    }
}
