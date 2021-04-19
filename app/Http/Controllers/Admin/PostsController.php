<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Scopes\PublishedScope;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    protected $validateRules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|int|exists:categories,id',
        'status' => 'required|in:draft,published',
        'image' => 'nullable|image|max:204800', //200KB
    ];

    public function __construct()
    {
        $this->middleware(['password.confirm'])->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT posts.*, categories.name AS category_name
        // FROM posts LEFT JOIN categories ON categories.id = posts.category_id

        $posts = Post::with('tags', 'category')
            //->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select([
                'posts.*',
                //'categories.name as category_name'
            ])
            ->latest() // ->orderBy('created_at', 'DESC')
            ->paginate();

        // Post::with('category')->latest()->paginate();

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create', [
            'post' => new Post(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'post_tags' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //$request->validate($this->validateRules());

        $image_path = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $image_path = $file->store('/', [
                'disk' => 'public'
            ]);
        }

        $post = Post::create([
            'title' => $request->post('title'),
            //'slug' => Str::slug($request->post('title')),
            'content' => $request->post('content'),
            'category_id' => $request->post('category_id'),
            'status' => $request->post('status'),
            'image' => $image_path,
            'user_id' => Auth::user()->id, // Auth::id() // $request->user()->id
        ]);

        $tags = $request->post('tag', []);
        $post->tags()->attach($tags);

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $post_tags = $post->tags()->pluck('id')->toArray();

        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'post_tags' => $post_tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        //$request->validate($this->validateRules());

        $post = Post::findOrFail($id);

        $image_path = $post->image;
        $old_image = $post->image;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            //$file->getClientOriginalName();
            //$file->getClientOriginalExtension();
            //$file->getSize();
            //$file->getMimeType(); // image/jpeg, image/png, ...
            
            $image_path = $file->store('/', [
                'disk' => 'public'
            ]);
        }

        // Mass assignment
        $post->update([
            'title' => $request->post('title'),
            //'slug' => Str::slug($request->post('title')),
            'content' => $request->post('content'),
            'category_id' => $request->post('category_id'),
            'status' => $request->post('status'),
            'image' => $image_path,
        ]);

        $tags = $request->post('tag', []);
        $post->tags()->sync($tags);

        if ($old_image && $old_image != $image_path) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Post::destroy($id);
        $post = Post::findOrFail($id); //
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    protected function validateRules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|int|exists:categories,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:204800', //200KB
        ];
    }

    public function image($id)
    {
        $post = Post::findOrFail($id);

        $path = storage_path('app/public/' . $post->image);
        return response()->download($path, 'image.jpg');
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->paginate();
        return view('admin.posts.trash', [
            'posts' => $posts,
        ]);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore(); // deleted_at = null

        return redirect()->route('admin.posts.index')->with('success', 'Post restored.');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        /*if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }*/

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted permenantly.');
    }
}
