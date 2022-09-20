<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $input['name'];
        $product->price = $input['price'];
        $product->detail = $input['detail'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
