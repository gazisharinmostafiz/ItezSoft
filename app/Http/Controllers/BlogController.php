<?php

namespace App\Http\Controllers; // Store in the main App\Http\Controllers namespace

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
    * Display a listing of published blog posts.
    */
    // public function index()
    // {
    //     // $posts = Post::where('status', 'published')
    //     //             ->whereNotNull('published_at')
    //     //             ->where('published_at', '<=', now())
    //     //             ->orderBy('published_at', 'desc')
    //     //             ->paginate(9); // Adjust pagination as needed

    //     $posts = Post::where('status', 'published')
    //          ->whereNotNull('published_at')
    //          ->where('published_at', '<=', now())
    //          ->orderBy('published_at', 'desc')
    //          ->paginate(9);
    //     $posts = Post::orderBy('created_at', 'desc')->paginate(9); // Get all posts, newest first
        
    //     return view('blog.index', compact('posts'));
    //     dd($posts); // <-- Add this line temporarily
    // }

//     public function index()
// {
//     $posts = Post::orderBy('created_at', 'desc')->paginate(9); // Get all posts
//     dd($posts); // Dump and die to inspect the $posts collection
//     return view('blog.index', compact('posts'));
// }
// public function index()
// {
//     $posts = Post::where('status', 'published')
//                  ->whereNotNull('published_at')
//                  ->where('published_at', '<=', now()) // This is the key filter
//                  ->orderBy('published_at', 'desc')
//                  ->paginate(9);

//     return view('blog.index', compact('posts'));
// }

// In app/Http/Controllers/BlogController.php
// public function index()
// {
//     $testPostId = 1; // <<<--- REPLACE THIS WITH THE ACTUAL ID
//     $testPost = \App\Models\Post::find($testPostId); // Make sure to use the Post model

//     if ($testPost) { // Check if post exists before accessing properties
//         dump("--- Debugging Post ID: " . $testPostId . " ---");
//         dump("Post Title: " . $testPost->title);
//         dump("Post Status: " . $testPost->status);
//         dump("Post published_at (raw from DB): " . $testPost->getRawOriginal('published_at'));

//         if ($testPost->published_at) { // Check if published_at is not null before trying to format it
//             dump("Post published_at (Carbon instance): " . $testPost->published_at->toDateTimeString());
//             dump("Post published_at (Timezone): " . $testPost->published_at->timezoneName);
//             dump("Is published_at <= now() ? : " . ($testPost->published_at->lte(now()) ? 'YES' : 'NO'));
//         } else {
//             dump("Post published_at is NULL.");
//         }

//         dump("now() (Carbon instance): " . now()->toDateTimeString());
//         dump("now() (Timezone): " . now()->timezoneName);
//         dump("Is status 'published'? : " . ($testPost->status === 'published' ? 'YES' : 'NO'));
//         dump("Is published_at NOT NULL? : " . (!is_null($testPost->published_at) ? 'YES' : 'NO'));
//     } else {
//         dump("Test post with ID " . $testPostId . " not found.");
//     }
//     dd("--- End Debug ---"); // Stop execution here for now

    // Original query (commented out during this debug)
    // $posts = \App\Models\Post::where('status', 'published')
    //              ->whereNotNull('published_at')
    //              ->where('published_at', '<=', now())
    //              ->orderBy('published_at', 'desc')
    //              ->paginate(9);
    // return view('blog.index', compact('posts'));
// }
// In app/Http/Controllers/BlogController.php
// public function index()
// {
//     $posts = \App\Models\Post::where('status', 'published')
//                  ->whereNotNull('published_at')
//                  ->where('published_at', '<=', now()) // The original query
//                  ->orderBy('published_at', 'desc')
//                  ->paginate(9);

//     dd($posts); // Dump the collection that results from THIS query

//     return view('blog.index', compact('posts'));
// }
public function index()
{
    $posts = \App\Models\Post::where('status', 'published')
                 ->whereNotNull('published_at')
                 ->where('published_at', '<=', now())
                 ->orderBy('published_at', 'desc')
                 ->paginate(9);

    // dd($posts); // REMOVE OR COMMENT THIS OUT

    return view('blog.index', compact('posts'));
}

    /**
    * Display the specified blog post.
    * Uses route model binding with the 'slug' field.
    */
    // public function show(Post $post) // Laravel will automatically find the post by its slug
    // {
    //     // Ensure the post is published and its publish date is not in the future
    //     if ($post->status !== 'published' || (isset($post->published_at) && $post->published_at->isFuture())) {
    //         abort(404); // Or redirect to blog index with a message
    //     }

    //     // Optional: Load related data like author, comments, etc.
    //     // $post->load('author', 'comments');

    //     return view('blog.show', compact('post'));
    // }

    public function show(Post $post)
{
    if ($post->status !== 'published' || (isset($post->published_at) && $post->published_at->isFuture())) {
        abort(404);
    }
    return view('blog.show', compact('post'));
}
}
