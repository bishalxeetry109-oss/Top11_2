<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a post.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:news,result,announcement',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image' => $imagePath,
            'type' => $request->type,
            'likes' => 0,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully');
    }

    /**
     * Show the form for editing a post.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:news,result,announcement',
        ]);

        $post = Post::findOrFail($id);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'content' => $request->content,
            'image' => $imagePath,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Delete a post.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }

    /**
     * View post comments.
     */
    public function viewComments($id)
    {
        $post = Post::with(['comments.user'])->findOrFail($id);
        return view('admin.posts.comments', compact('post'));
    }

    /**
     * Delete a comment.
     */
    public function deleteComment($postId, $commentId)
    {
        $comment = PostComment::where('post_id', $postId)->where('id', $commentId)->firstOrFail();
        $comment->delete();

        return redirect()->route('admin.posts.comments', $postId)
            ->with('success', 'Comment deleted successfully');
    }
}
