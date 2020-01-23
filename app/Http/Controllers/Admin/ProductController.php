<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Brand;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductFormRequest;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $pageTitle = 'Products';
        $subTitle = 'Products List';
        return view('admin.products.index', compact('products', 'pageTitle', 'subTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        // $categories = Category::all();
        $nodes = Category::get()->toTree();
        $tree = $this->categoriesTree($nodes);
        $pageTitle = 'Products';
        $subTitle = 'Create Product';
        return view('admin.products.create', compact('brands', 'tree', 'pageTitle', 'subTitle'));
    }

    public function categoriesTree($nodes)
    {
        $traverse = function ($categories, $prefix = "&nbsp") use (&$traverse) {
            $ops = '';
            foreach ($categories as $category) {
                $ops .= "<option value=".$category->id.">".$prefix.'&nbsp'.$category->name."</option>";
                $ops .= $traverse($category->children, $prefix.'&nbsp&nbsp');
            }
            return $ops;
        };
        return $traverse($nodes);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');
        try {
            $collection = collect($params);

            $featured = $collection->has('featured') ? 1 : 0;
            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('status', 'featured'));

            $product = new Product($merge->all());

            $product->save();

            if ($collection->has('categories')) {
                $product->categories()->sync($params['categories']);
            }
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }

        if (!$product) {
            return redirect(route('admin.products.index'))->with('error', 'Error occurred while creating product!');
        }

        return redirect(route('admin.products.index'))->with('success', 'Product Created Successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();

        $pageTitle = 'Products';
        $subTitle = 'Edit Products : '.$product->name;
        return view('admin.products.edit', compact('categories', 'brands','product', 'pageTitle', 'subTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductFormRequest $request, Product $product)
    {
        $params = $request->except('_token');

        $collection = collect($params)->except('_token');

        $featured = $collection->has('featured') ? 1 : 0;
        $status = $collection->has('status') ? 1 : 0;

        $merge = $collection->merge(compact('status', 'featured'));

        $product->update($merge->all());

        if ($collection->has('categories')) {
            $product->categories()->sync($params['categories']);
        }

        if (!$product) {
            return redirect(route('admin.products.index'))->with('error', 'Error occurred while updating product!');
        }

        return redirect(route('admin.products.index'))->with('success', 'Product updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function findProductBySlug($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return $product;
    }
}
