<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view("color.index", compact('colors'));
    }
    public function create()
    {
        return view("color.form");
    }
    public function edit($color)
    {
        if($color)
        {
            $color = Color::find($color);
            if($color)
            {
                return view("color.form", compact('color'));
            }
        }
        return redirect()->back()->withFailed('Color not found');
    }
    public function update(Request $request, $id)
    {
        $rules = array(
            'name'=>'required',
            'color'=>'required',
            'status'=>'required'
        );
        $this->validate($request, $rules);
        try 
        {
            $color=Color::where('id',$id)->first();

            if($color)
            {
                $color->name = $request->name;
                $color->color = $request->color;
                $color->status = $request->status;

                if($color->save())
                {
                    return redirect('/color')->withSuccess(' color successfully updated.');
                }
                return redirect()->back()->withFailed('color not updated');
            }
            return redirect()->back()->withFailed('color not found');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception:'.$e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $rules = array(
            'name'=>'required',
            'color'=>'required',
            'status'=>'required'
        );
        
        $this->validate($request, $rules);
        try{
            $form = Color::create([
                'name'=> $request->name,
                'color'=>$request->color,
                'status'=>$request->status
            ]);
            if($form)
            {
                return redirect('/color')->with('success','Color successfully created');
            }
            return redirect()->back()->withFailed('Color not created');
        }
        catch(Exception $e)
        {
            return redirect()->back()->withFailed('Exception: '.$e->getMessage());
        }
    }
    public function destroy($id)
    {
        if($id)
        {
            $color = Color::find($id);
            if($color)
            {
                $color->delete();
                return redirect()->back()->withSuccess('Color successfully deleted');
            }
        }
        return redirect()->back()->withFailed('Color not found');
    }
}
