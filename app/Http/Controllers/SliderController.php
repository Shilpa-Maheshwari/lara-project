<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('type','home')->orderBy('order_number','asc')->get();
        return view("slider.home-index", compact('sliders'));
    }
    public function create()
    {
        return view("slider.home-form");
    }
    public function edit($slider)
    {
        if($slider)
        {
            $slider = Slider::find($slider);
            if($slider)
            {
                return view("slider.home-form", compact('slider'));
            }
        }
        return redirect()->back()->withFailed('Slider not found');
    }
    public function update(Request $request, $id)
    {
        $webFileName='';
        if($request->web_status=='')
        {
            return redirect()->back()->withFailed('Please select any one (app status or web status)');
        }
        if($id)
        {
            $slider = Slider::find($id);
            if($slider)
            {
                $slider->type = 'home';
    
                if($request->web_status!='' and $request->hasFile('web_image'))
                {
                    $webFileName = 'slider_'.time().'.'.$request->web_image->extension();  
                }
                $slider->web_status= $request->web_status=='1'?'1':'0';
                               
                if($webFileName)
                {
                    $old_web_image=$slider->web_image;
                    $request->web_image->move(public_path('home_slider/web'), $webFileName);
                    if(File::exists('home_slider/web/'.$old_web_image)) 
                    {
                        File::delete('home_slider/web/'.$old_web_image);
                    }
                    $slider->web_image = $webFileName;
                }else{
                    $slider->web_image = $slider->web_image;
                }

                $slider->order_number = $slider->order_number;
                            
                if($slider->save())
                {
                    return redirect('config/slider')->withSuccess('Slider successfully update');
                }
                return redirect('config/slider')->withFailed('Slider not updated');
            }
        }
        return redirect()->back()->withFailed('Slider not found');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $webFileName='';
        if($request->web_status=='')
        {
            return redirect()->back()->withFailed('Please select any one (web status)');
        }
        if($request->web_status)
        {
            $this->validate($request, [
                'web_image'=>'required|mimes:jpg,jpeg,png'
            ]);
            $webFileName = 'slider_' . time() . '.'. $request->web_image->extension();  
        }
        
        if($webFileName)
        {
            $request->web_image->move(public_path('home_slider/web'), $webFileName);
        }
        
        $nextOrderNumber = Slider::where('type', 'home')->max('order_number');
        $slider = Slider::create([
            'web_status'=>$request->web_status=='1'?'1':'0',
            'web_image'=>$webFileName,
            'type'=>'home',
        ]);
        if($slider)
        {
            $slider->order_number =  $nextOrderNumber ? $nextOrderNumber+1:1;
            $slider->save();

            return redirect('config/slider')->withSuccess('Slider successfully added');
        }
    }

    public function destroy($id)
    {
        if($id)
        {
            $slider = Slider::find($id);
            if($slider)
            {
                if($slider->web_image)
                {
                    if(File::exists('home_slider/web/'.$slider->web_image)) 
                    {
                        File::delete('home_slider/web/'.$slider->web_image);
                    }
                }
                $slider->delete();
                return redirect()->back()->withSuccess('Slider successfully deleted');
            }
        }
        return redirect()->back()->withFailed('Slider not found');
    }
}
