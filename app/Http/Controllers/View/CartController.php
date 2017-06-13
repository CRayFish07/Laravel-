<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\CartItem;
use App\Entity\Product;

class CartController extends Controller
{
    public function tocart(Request $request){
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart=$bk_cart!=null?explode(",",$bk_cart):array());
        $cartitems = array();

        $member = $request->session()->get("member","");
        if ($member!=""){

        }
        foreach ($bk_cart_arr as $key=>$value){
            $index = strpos($value,":");
            $num = substr($value,$index+1);

            $cartitem = new CartItem();
            $cartitem->id = $key;
            $cartitem->product_id = substr($value,0,$index);
            $cartitem->count = $num;
            $cartitem->product = Product::find($cartitem->product_id);
            if ($cartitem->product!=null){
                array_push($cartitems,$cartitem);
            }
        }
        return View('cart')->with("cart_items",$cartitems);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
