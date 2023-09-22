<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('pages.posts.index', compact('posts'));
    }

    public function create()
    {

        return view('pages.posts.index');
    }

    public function store(PostStoreRequest $request)
    {
        Post::create($request->validated());

        return redirect()->route('posts.index')->with('success', 'Created Post Successfully!');
    }

    public function show(Post $post)
    {
        return view('pages.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        // Gate::authorize('post-gate', $post);

        // $response = Gate::inspect('post-gate', $post);
        // if($response->allowed()){
        //     $post->delete();
        //     return back()->with('success', 'Post Deleted Successfully!');
        // } else{
        //     return back()->with('error', $response->message());
        // }

        if(auth()->id() !== $post->author_id){
            return back()->with('error', 'You need permission to delete this post!');
        }

        $post->delete();
        return back()->with('success', 'Post Deleted Successfully!');
    }
}
