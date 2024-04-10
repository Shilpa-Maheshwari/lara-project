<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function productDetailes($id)
    {
        if($id)
        {
            $id= decrypt($id);
            $products = Product::find($id);
            $multi_image = Product::select('multi_image')->where('id', $id)->pluck('multi_image');
            $images = explode(',',$multi_image);
             $images =str_replace(array( '["', '"]' ), '',  $images);
            if($products)
            {
                return view('site.product_detailes',compact('products','images'));
            }
        }
    }
    public function content()
    {
        $products = Product::all();
        return view('site.content', compact('products'));
    }
}
