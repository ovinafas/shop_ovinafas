<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $attributes = Attribute::all();
       
        $pageTitle = 'Attributes';
        $subTitle = 'List of all attributes';
        return view('admin.attributes.index', compact('attributes', 'pageTitle', 'subTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Attributes';
        $subTitle = 'Create Attribute';
        return view('admin.attributes.create', compact('pageTitle', 'subTitle'));
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
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'
        ]);

        $params = $request->except('_token');

        try {
            $collection = collect($params);

            $is_filterable = $collection->has('is_filterable') ? 1 : 0;
            $is_required = $collection->has('is_required') ? 1 : 0;

            $merge = $collection->merge(compact('is_filterable', 'is_required'));

            $attribute = new Attribute($merge->all());

            $attribute->save();

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }

        if (!$attribute) {
            return redirect(route('admin.attributes.index'))->with('error', 'Error occurred while creating attribute!');
        }
        return redirect(route('admin.attributes.index'))->with('success', 'Attribute Created Successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $pageTitle = 'Attributes';
        $subTitle = 'Edit Attribute : '.$attribute->name;
        return view('admin.attributes.edit', compact('attribute', 'pageTitle', 'subTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $this->validate($request, [
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);
        $attribute = $this->findAttributeById($params['id']);

        $collection = collect($params)->except('_token');

        $is_filterable = $collection->has('is_filterable') ? 1 : 0;
        $is_required = $collection->has('is_required') ? 1 : 0;

        $merge = $collection->merge(compact('is_filterable', 'is_required'));
        $attribute->update($merge->all());

        if (!$attribute) {
            return redirect(route('admin.attributes.index'))->with('error', 'Error occurred while updating attribute!');
        }
        return redirect(route('admin.attributes.index'))->with('success', 'Attribute Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        if (!$attribute) {
            return redirect(route('admin.attributes.index'))->with('error', 'Error occurred while deleting attribute!');
        }
        $attribute->delete();
        return redirect(route('admin.attributes.index'))->with('success', 'Attribute deleted Successfully!');
    }
}
