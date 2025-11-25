<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Home';
        $header = 'Home';
        $user = Auth::user();
        $posts = Post::latest()->take(6)->get();
        return view('home', compact('user', 'header', 'title', 'posts'));
    }
}
