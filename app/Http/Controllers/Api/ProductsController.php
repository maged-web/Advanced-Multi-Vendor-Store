<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
   // 1|AUlM5kp6ScjMSRyl7ptokBWxXYcybN7MP5d1Qa0I8e80b461"
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show');

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //


         $products = Product::filter($request->query())
        ->with(['category:id,name','store','tags'])
        ->paginate(); 
        return $products;
        // return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'required|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);
        $user =$request->user();
        if(!$user->tokenCan('products.create'));
        {
            abort(403,'not allowed');
        }
       $product = Product::create($request->all());

       return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
       // return new ProductResource($product);
        return $product->load(['category:id,name','store','tags']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        //
        $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'sometimes|required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'sometimes|required|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);
        $user =$request->user();
        if(!$user->tokenCan('products.update'))
        {
            abort(403,'not allowed');
        }
       $product->update($request->all());

       return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user =Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.delete'))
        {
           return response(['message'=>'not allowed'],403);
        }
        Product::destroy($id);
        return ['message'=>'Product Delted Successfully'];
    }
}
