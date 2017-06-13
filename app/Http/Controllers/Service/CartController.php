<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M3result;

class CartController extends Controller
{

   public function addcart(Request $request,$product_id){
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart=$bk_cart!=null?explode(",",$bk_cart):array());
        $count=1;
        foreach ($bk_cart_arr as &$value){
             $index = strpos($value,":");
             $num = substr($value,$index+1);
             if (substr($value,0,$index)==$product_id){
                 $count = ((int) $num)+1;
                 $value = $product_id.':'.$count;
             }
         }
             if ($count==1){
                 array_push($bk_cart_arr,$product_id.":".$count);
             }

             $m3result = new M3result();
             $m3result->status = 0;
             $m3result->message = "添加成功";
             return response($m3result->toJson())->withCookie("bk_cart",implode(',',$bk_cart_arr));

   }

    public function delete(Request $request){
       $m3result = new M3result();
       $product_ids = $request->input("product_ids");
       $product_id = explode(",",$product_ids);
       $bk_cart = $request->cookie('bk_cart');
       $bk_cart_arr = ($bk_cart=$bk_cart!=null?explode(",",$bk_cart):array());
       foreach ($bk_cart_arr as $key => $value){
           $index = strpos($value,":");
           $num = substr($value,$index+1);
           if (in_array(substr($value,0,$index),$product_id)){
               array_splice($bk_cart_arr,$key,1);
           }
       }
       $m3result->status=0;
       $m3result->message="ok";
       return response($m3result->toJson())->withCookie("bk_cart",implode(',',$bk_cart_arr));

   }
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
