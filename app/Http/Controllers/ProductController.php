<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Color;
use App\Models\Product;
use App\Models\Measurment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
     public function index()
     {
        $products = Product::all();
        return view("product.index", compact('products'));
     }
     public function create()
     {
        $colors = Color::all();
        $measurments = Measurment::all();
        return view('product.add', compact('colors', 'measurments'));
     }

     public function store(Request $request)
    {
        // dd($request->all());
        $rules = array(
            'name'=>'required',
            'price'=>'required|numeric|min:0',
            'measurment_id'=>'required|numeric',
            'color_id'=>'required|numeric',
            'description'=>'required',
            'weight'=>'required|numeric', 
        );
        $image='';
        if($request->hasFile('image'))
        {
            $rules['image']= 'required|file|mimes:jpg,jpeg,png';
            $image = 'product_' . time() . '.'. $request->image->extension();  
        }
        $multi_image=[];
        if($request->hasfile('multi_image'))
        {
            $rules['multi_image.*']='required|file|mimes:jpg,jpeg,png';
        }
        $this->validate($request, $rules);
       
        try
        {
            $product = new Product();
            $product->name= $request->name;
            $product->price = $request->price;
            $product->measurment_id = $request->measurment_id;
            $product->color_id = $request->color_id;
            $product->description = $request->description;
            $product->weight = $request->weight;
            if($image)
            {
                $request->image->move(public_path('product_image'), $image);
                $product->image=$image;
            }
            foreach($request->file('multi_image') as $file)
            {    
                $files_name = 'product_' . time().rand(0,100) . '.'. $file->extension();  
                $file->move(public_path('product_image'), $files_name);
                $multi_image[]= $files_name;
            }
            $product->multi_image = implode('[,]' ,$multi_image);
            
            if($product->save())
            { 
                return redirect('/product')->with('success','Product Successfully Created');
            }
            return redirect()->back()->withFailed('Product Not Created');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception: '.$e->getMessage());
        }
    }
    public function edit($id) //edit
    {
        $multi_image = Product::select('multi_image')->where('id', $id)->pluck('multi_image');
       
        $images = explode(',',$multi_image);
         $images =str_replace(array( '["', '"]' ), '',  $images);
        if($id)
        {
            $colors= Color::all();
            $measurments= Measurment::all();
            $product = Product::where(['id'=>$id])->first();
            if($product)
            {
                return view("product.edit", compact('product', 'colors', 'measurments','images'));
            }
            return redirect()->back()->withFailed('Product not found');
        }
        return redirect()->back()->withFailed('Bad Request');
    }
    public function update(Request $request, $id)
    {
        $rules = array(
            'name'=>'required',
            'price'=>'required|numeric|min:0',
            'measurment_id'=>'required|numeric',
            'color_id'=>'required|numeric',
            'description'=>'required',
            'weight'=>'required|numeric', 
        );

        $image='';
        if($request->hasFile('image'))
        {
            $rules['image']= 'required|file|mimes:jpg,jpeg,png';
            $image = 'product_' . time() . '.'. $request->image->extension();  
        }
        $multi_image=[];
        if($request->hasfile('multi_image'))
        {
            $rules['multi_image.*']='required|file|mimes:jpg,jpeg,png';
        }
        $this->validate($request, $rules);
        try
        {
            $product = Product::where('id',$id)->first();
            if($product)
            {
                $product->name = $request->name;
                $product->price = $request->price;
                $product->color_id = $request->color_id;
                $product->measurment_id = $request->measurment_id; 
                $product->description = $request->description;
                $product->weight = $request->weight;
                if($image)
                {
                    $old_image=$product->image;
                    $request->image->move(public_path('product_image'), $image);
                    //$data['image']=$image;
                    if(File::exists('product_image/'.$old_image)) 
                    {
                        File::delete('product_image/'.$old_image);
                    }
                    $product->image = $image;
                }
                if($multi_image)
                {
                    $old_multi_image=$product->multi_image;
                    $request->multi_image->move(public_path('product_image'), $old_multi_image);
                    //$data['image']=$image;
                    if(File::exists('product_image/'.$old_multi_image)) 
                    {
                        File::delete('product_image/'.$old_multi_image);
                    }
                    $product->multi_image = $multi_image;
                }
                if($product->save())
                {
                    return redirect('/product')->withSuccess('Product Successfully Updated.');
                }
                return redirect()->back()->withFailed('Product not updated.');
            }
            return redirect()->back()->withFailed('Product not found');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception: '.$e->getMessage());
        }
    }
}
