<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;

class BrandController extends Controller
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
       
        $pageTitle = 'Brands';
        $subTitle = 'List of all brands';
        return view('admin.brands.index', compact('brands', 'pageTitle', 'subTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Brands';
        $subTitle = 'Create Brand';
        return view('admin.brands.create', compact('pageTitle', 'subTitle'));
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
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        try {
            $collection = collect($params);
            $logo = null;

            if ($collection->has('logo') && ($params['logo'] instanceof  UploadedFile)) {
                $logo = $this->uploadOne($params['logo'], 'brands');
            }

            $merge = $collection->merge(compact('logo'));
            $brand = new Brand($merge->all());
            $brand->save();

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
        if (!$brand) {
            return redirect(route('admin.brands.index'))->with('error', 'Error occurred while creating brand!');
        }
        return redirect(route('admin.brands.index'))->with('success', 'Brand Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $pageTitle = 'Brands';
        $subTitle = 'Edit Brand : '.$brand->name;
        return view('admin.brands.edit', compact('brand', 'pageTitle', 'subTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');
        $collection = collect($params)->except('_token');

        if ($collection->has('logo') && ($params['logo'] instanceof  UploadedFile)) {

            if ($brand->logo != null) {
                $this->deleteOne($brand->logo);
            }

            $logo = $this->uploadOne($params['logo'], 'brands');
        }

        $merge = $collection->merge(compact('logo'));

        $brand->update($merge->all());

        if (!$brand) {
            return redirect(route('admin.brands.index'))->with('error', 'Error occurred while updating brand!');
        }
        
        return redirect(route('admin.brands.index'))->with('success', 'Brand Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if (!$brand) {
            return redirect(route('admin.brands.index'))->with('error', 'Error occurred while deleting brand!');
        }

        if ($brand->logo != null) {
            $this->deleteOne($brand->logo);
        }

        $brand->delete();
        return redirect(route('admin.brands.index'))->with('success', 'Brand deleted Successfully!');
    }
}
