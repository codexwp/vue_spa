<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $data = $request->only(['title','description','status']);
        $data['user_id'] = auth()->id();
        Post::create($data);
        return response()->json(['success' => true, 'message' => 'Successfully created.']);
    }

    public function show(int $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->first();
        if($post)
            return $post;
        return response()->json(['success' => false, 'message' => 'Post is not found.'], 412);    
    }

    public function update(Request $request, int $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->first();
        if($post === null)
            return response()->json(['success' => false, 'message' => 'Post is not found.'], 412);  

        $data = $request->only(['title','description','status']);
        $post->update($data);
        return response()->json(['success' => true, 'message' => 'Successfully updated.']);
    }

    public function destroy(int $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->first();
        if($post === null)
            return response()->json(['success' => false, 'message' => 'Post is not found.'], 412);  

        $post->delete();    
        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);    
    }


}
