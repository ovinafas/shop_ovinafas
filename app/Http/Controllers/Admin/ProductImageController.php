<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductImage;
use Illuminate\Http\Request;
use App\Traits\UploadAble;
use App\Product;

class ProductImageController extends Controller
{
    use UploadAble;

    public function upload(Request $request)
    {

        $product = Product::where('id', $request->product_id)->first();
        if ($request->has('image')) {
            $image = $this->uploadOne($request->image, 'products');
            $productImage = new ProductImage([
                'full'      =>  $image,
            ]);
            $product->images()->save($productImage);
        }

        return response()->json(['status' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImage)
    {
        //
    }
}
