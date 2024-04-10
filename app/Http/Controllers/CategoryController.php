<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $categories = Category::all();
        return view("category.index", compact('categories'));
    }

    public function categoryCreate()
    {
        return view("category.form");
    }

    public function categoryStore(Request $request)
    {
        $rules = array(
            'name'=>'required',
        );
        $image='';
        if($request->hasFile('image'))
        {
            $rules['image']= 'required|file|mimes:jpg,jpeg,png';
            $image = 'category_' . time() . '.'. $request->image->extension();
        }
        $this->validate($request, $rules);
        try
        {
            $data['name']= $request->name;
            if($image)
            {
                $request->image->move(public_path('category_image'), $image);
                $data['image']=$image;
            }
            $category = Category::create($data);

            if($category)
            {
                return redirect('/category')->with('success','Category successfully created');
            }
            return redirect()->back()->withFailed('Category not created');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception: '.$e->getMessage());
        }
    }

    public function categoryEdit($id)
    {
        if($id)
        {
            $category = Category::where('id', $id)->first();
            if($category)
            {
                return view("category.form", compact('category'));
            }
            return redirect()->back()->withFailed('Category not found');
        }
        return redirect()->back()->withFailed('Bad Request');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $rules = array(
            'name'=>'required',
        );
        $image='';
        if($request->hasFile('image'))
        {
            $rules['image']= 'required|file|mimes:jpg,jpeg,png';
            $image = 'category_' . time() . '.'. $request->image->extension();
        }
        $this->validate($request, $rules);

        try{
            $category = Category::where('id',$id)->first();

            if($category)
            {
                $category->name = $request->name ? $request->name : $category->name;
                if($image)
                {
                    $old_image=$category->image;
                    $request->image->move(public_path('category_image'), $image);
                    $data['image']=$image;

                    if(File::exists('category_image/'.$old_image))
                    {
                        File::delete('category_image/'.$old_image);
                    }
                    $category->image = $image;
                }
                if($category->save())
                {
                    return redirect('/category')->withSuccess('Category successfully updated.');
                }
                return redirect()->back()->withFailed('Category not updated.');
            }
            return redirect()->back()->withFailed('Category not found');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception: '.$e->getMessage());
        }
    }

    public function categoryDestroy($id)
    {
        if($id)
        {
            $category = Category::where(['id'=>$id])->first();
            if($category)
            {
                if($category->image)
                {
                    if(File::exists('category_image/'.$category->image))
                    {
                        File::delete('category_image/'.$category->image);
                    }
                }
                $category->delete();
                return redirect()->back()->withSuccess('Category successfully deleted');
            }
            return redirect()->back()->withFailed('Category not found');
        }
        return redirect()->back()->withFailed('Bad Request');
    }
}
