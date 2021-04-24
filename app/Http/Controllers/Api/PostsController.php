<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with('category:id,name,slug', 'user:id,name,email')
            ->select([
                'id', 'title', 'slug', 'content', 'image', 'category_id', 'user_id'
            ])
            ->paginate(); // json_encode(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user->tokenCan('posts.create')) {
            abort(403);
        };

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|int|exists:categories,id',
            'image' => 'image',
            'tags' => 'array'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image')->store('/', 'public');
        }

        $post = Post::create($data);

        $post->tags()->sync($request->post('tag'));

        return response()->json($post, 201);
        return new JsonResponse($post, 201);
        return Response::json($post, 201);
        return response($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post->load('category', 'user.profile', 'tags');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user->tokenCan('posts.update')) {
            abort(403, 'Not allowed');
        };

        $request->validate([
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'category_id' => 'sometimes|required|int|exists:categories,id',
            'image' => 'image',
            'tags' => 'array'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image')->store('/', 'public');
        }
        $old_image = $post->image;

        $post->update($data);
        $post->tags()->sync($request->post('tag'));

        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        return [
            'message' => 'Post updated',
            'post' => $post->load('tags'),
        ];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user->tokenCan('posts.delete')) {
            abort(403, 'Not allowed');
        };

        Post::destroy($id);

        return Response::json([
            'message' => "Post $id deleted",
        ]);
    }
}
