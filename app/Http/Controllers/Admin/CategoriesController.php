<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class CategoriesController extends Controller
{
    
    public function index()
    {
        $this->authorize('view-any', Category::class);

        // SELECT * FROM categories
        // LEFT JOIN categories as parent ON parent.id = categories.parent_id

        /*$categories = Category::leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            //->leftJoin('posts', 'posts.category_id', '=', 'categories.id')
            ->select([
                'categories.*',
                'parent.name as parent_name',
                //DB::raw('(SELECT COUNT(*) FROM posts WHERE posts.category_id = categories.id) as posts_count'),
            ])
            ->selectRaw('(SELECT COUNT(*) FROM posts WHERE posts.category_id = categories.id) as posts_count')
            ->orderBy('categories.parent_id', 'ASC')
            ->orderBy('categories.name', 'ASC')
            /*->groupBy([
                'categories.id',
                'categories.name',
                'categories.parent_id',
                'categories.created_at',
                'parent_name',
            ])*/
            //->paginate();

        // with eager loading
        // SELECT * FROM categories
        // SELECT * FROM categories WHERE id IN (...)
        $categories = Category::with('parent')->withCount('posts as posts_no')
            ->withCount('children')->paginate();

        return view('admin.categories.index', [
            'categories' => $categories,
            'title' => 'Categories',
        ]);
    }

    public function create()
    {
        $this->authorize('create', Category::class);

        // SELECT * FROM categories
        // SELECT id, name FROM categories

        return view('admin.categories.create', [
            'category' => new Category(),
            'parents' => Category::all(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        //$request->name;
        //$request->input('name');
        //$request->get('name');
        //$request->post('name');
        //$request->query('name');

        //dd($request->except('_token', 'parent_id'));

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3|unique:categories,name',
            'parent_id' => 'nullable|int|exists:categories,id',
        ]);

        /*if ($validator->fails()) {
            dd( $validator->errors() );
        }*/
        $validator->validate();

        $category = new Category();
        $category->name = $request->post('name');
        $category->slug = Str::slug($request->post('name'));
        $category->parent_id = $request->post('parent_id');

        $category->save();

        // /admin/categories
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created!');
    }

    public function edit(Category $category)
    {
        // SELECT * FROM categories WHERE id = $id
        /*$category = Category::find($id);
        if ($category == null) {
            abort(404);
        }*/

        $this->authorize('update', $category);

        $parents = Category::where('id', '<>', $id)->get();

        return view('admin.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $unique = new Unique('categories', 'name');
        $unique->ignore($category->id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                //'unique:categories,name,' . $id,
                //Rule::unique('categories', 'name')->ignore($id),
                $unique,
                function($attribute, $value, $fail) {
                    if ($value == 'god') {
                        $fail('This word is not allowed!');
                    }
                }
            ],
            'parent_id' => 'nullable|int|exists:categories,id',
        ], [
            'required' => '?????? ?????????? ??????????',
            'min' => '???????? ?????????? ?????????? ???????? ???? ????????????',
        ]);

        //$category = Category::findOrFail($id);

        $this->authorize('update', $category);

        $category->name = $request->post('name');
        $category->slug = Str::slug($request->post('name'));
        $category->parent_id = $request->post('parent_id');

        $category->save();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        // Method 1
        //$category = Category::findOrFail($id);
        
        $this->authorize('delete', $category);
        
        $category->delete();

        // Method 2
        //Category::where('id', '=', $id)->delete();

        // Method 3
        //Category::destroy($id);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted!');
    }
}
