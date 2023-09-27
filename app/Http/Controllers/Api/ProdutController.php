<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Validator;

class ProdutController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $products = Product::all();
           //   return $this->sendRespons($products,'all product');
            // return $this->sendRespons($products->toArray(),'all product');
            return $this->sendRespons(ProductResource::collection($products),'all product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title' => 'required',
            'description'=>'required',
        ]);
        if ($validation -> fails()) {
            return $this->sendError('product validation error',$validation->errors());
        }

       $product = Product::create([
        'title'=>$request->title,
        'description'=> $request->description
       ]);

      return $this->sendRespons(new ResourceResponse($product),'product create successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return $this->sendRespons($product,'sinngle product');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        $validation = validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
        ]);
        if ($validation -> fails()) {
            return $this->sendError('update product validation error',$validation->errors());
        }
        $product->update([
            'title'=>$request->title,
            'description'=>$request->description,
        ]);

        return $this->sendRespons(new ProductResource($product),'product update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        // return $this->sendRespons($product,'product delete');
        return $this->sendRespons(new ProductResource($product),'product delete');
    }
}
