<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Import Storage facade for file operations

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('author')->latest()->paginate(10); // Eager load author
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title', // Ensure title is unique
            'content' => 'required|string', // Quill sends HTML, so string is fine. Sanitize on display!
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000', // Increased max length
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Store in 'public/post_images' directory, which links to 'storage/app/public/post_images'
            // Ensure you've run `php artisan storage:link`
            $path = $request->file('featured_image')->store('post_images', 'public');
            $validatedData['featured_image'] = $path; // Store the path
        }

        // The Post model's boot method should handle slug generation automatically if title is provided.
        // If you want to manually set user_id (e.g., if you have admin authentication)
        // $validatedData['user_id'] = auth()->id(); // Make sure auth()->id() is available and relevant

        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // For admin, typically redirect to edit or show a simplified view.
        // Frontend will have its own show method.
        return view('admin.posts.show', compact('post')); // You'll need to create this view if you use it
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post')); // We'll create this view next
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id, // Unique, ignoring current post
            'content' => 'required|string', // Quill sends HTML
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            // Store new image
            $path = $request->file('featured_image')->store('post_images', 'public');
            $validatedData['featured_image'] = $path;
        }

        // The Post model's boot method should handle slug update if title changes.
        // If user_id needs to be updated (e.g., changing author)
        // $validatedData['user_id'] = $request->input('user_id', $post->user_id);

        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete associated featured image from storage
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
