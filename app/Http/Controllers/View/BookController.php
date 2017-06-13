<?php

namespace App\Http\Controllers\View;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use App\Tools\ValidataCode;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;

class BookController extends Controller
{
    public function tocategory(){
        $categorys = Category::whereNull('parent_id')->get();
        return View('category')->with('categorys',$categorys);
    }
    public function tobooklist($category_id){
        $products = Product::where('category_id',$category_id)->get();
        return View('product')->with('products',$products);
    }
    public  function toproduct(Request $request,$product_id){
        $product = Product::where("id",$product_id)->first();
        $pdt_content = Pdt_content::find($product_id);
        $pdt_images = Pdt_images::where("product_id",$product_id)->get();

        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = explode(',',$bk_cart);

        $count = 0;
        foreach ($bk_cart_arr as $value){
            $index = strpos($value,':');
            if ($product_id==substr($value,0,$index))
            {
                $count = substr($value,$index+1);
                break;
            }
        }
        return View('pdt_content')->with('product',$product)->with('pdt_content',$pdt_content)->with('pdt_images',$pdt_images)->with("count",$count);
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
