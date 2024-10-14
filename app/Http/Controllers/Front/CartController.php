<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositiories\Cart\CartModelRepositories;
use App\Repositiories\Cart\CartRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartRepositories $cart)
    {
        $this->cart=$cart;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(/* CartRepositories $cart */)
    {
        //
        return view('front.cart',[
            'cart'=>$this->cart
        ]);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepositories $cart)
    {
        //
        $request->validate([
            'product_id'=>'required|int|exists:products,id',
            'quantity'=>['nullable','int','min:1'],
        ]);


        $product=Product::findOrFail($request->post('product_id'));
        $cart->add($product,$request->post(key: 'quantity'));

        return redirect()->route('cart.index')->with('success','Product added to cart!');

    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'quantity'=>['required','int','min:1'],
        ]);
       $this->cart->update($id,$request->post(key: 'quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $this->cart->delete($id);
        return [
            'message'=>'Item deleted!'
        ];
    }
}
