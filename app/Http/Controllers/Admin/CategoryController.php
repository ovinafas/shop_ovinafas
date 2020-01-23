<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Traits\UploadAble;

class CategoryController extends Controller
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        $pageTitle = 'Categories';
        $subTitle = 'List of all categories';
        return view('admin.categories.index', compact('categories', 'pageTitle', 'subTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $pageTitle = 'Categories';
        $subTitle = 'Add new category';
        return view('admin.categories.create', compact('categories', 'pageTitle', 'subTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            // 'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $image = null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            $image = $this->uploadOne($params['image'], 'categories');
        }

        $featured = $collection->has('featured') ? 1 : 0;
        $menu = $collection->has('menu') ? 1 : 0;
        $merge = $collection->merge(compact('menu', 'image', 'featured'));
        $category = new Category($merge->all());

        $category->save();

        return redirect(route('admin.categories.index'))->with('success', 'Category Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::pluck('name', 'id');
        $pageTitle = 'Categories';
        $subTitle = 'Edit category';
        return view('admin.categories.edit', compact('category', 'categories', 'pageTitle', 'subTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            // 'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            if ($category->image != null) {
                $this->deleteOne($category->image);
            }
            $image = $this->uploadOne($params['image'], 'categories');
        } else {
            $image = null;
        }

        $featured = $collection->has('featured') ? 1 : 0;
        $menu = $collection->has('menu') ? 1 : 0;
        $merge = $collection->merge(compact('menu', 'image', 'featured'));
        $category->update($merge->all());

        return redirect(route('admin.categories.index'))->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->image != null) {
            $this->deleteOne($category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category Deleted Successfully!');
    }
}
