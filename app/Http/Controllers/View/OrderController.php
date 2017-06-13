<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Order_item;

class OrderController extends Controller
{

    public  function toorderlist(Request $request){
        $member = $request->session()->get('member', '');
        $orders = Order::where('member_id', $member->id)->get();
        foreach ($orders as $order) {
            $order_items = Order_item::where('order_id', $order->id)->get();
            $order->order_items = $order_items;
            foreach ($order_items as $order_item) {
                $order_item->product = json_decode($order_item->pdt_snapshot);
            }
        }

        return view('order_list')->with('orders', $orders);
    }

    public function toordercommit(Request $request,$product_arr){
        $product_id = ($product_arr!=""? explode(",",$product_arr):array());
        $member = $request->session()->get("member","");
        $cartitems = CartItem::where('member_id',$member->id)->whereIn('product_id',$product_id)->get();

        $cartitem_arr = array();
        $price = 0;
        foreach ($cartitems as $cartitem){
            $cartitem->product = Product::find($cartitem->product_id);
            if ($cartitem->product != null){
                $price+=$cartitem->product->price*$cartitem->count;
                array_push($cartitem_arr,$cartitem);
            }
        }
        return View("order_commit")->with('cart_items',$cartitem_arr)->with("price",$price);
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
