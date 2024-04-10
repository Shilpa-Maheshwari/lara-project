<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Measurment;
use Illuminate\Http\Request;

class MeasurmentController extends Controller
{
    public function index()
    {
        $measurs = Measurment::all();
        return view("measurment.index", compact('measurs'));
    }
    public function create()
    {
        return view("measurment.form");
    }
    public function edit($measur)
    {
        if($measur)
        {
            $measur= Measurment::find($measur);
            if($measur)
            {
                return view("measurment.form", compact('measur'));
            }
        }
        return redirect()->back()->withFailed('Measurment not found');
    }
    public function update(Request $request, $id)
    {
        $rules = array(
            'name'=>'required',
        );
        $this->validate($request, $rules);
        try 
        {
            $measurs=Measurment::where('id',$id)->first();

            if($measurs)
            {
                $measurs->name = $request->name;

                if($measurs->save())
                {
                    return redirect('/measurment')->withSuccess(' measurment successfully updated.');
                }
                return redirect()->back()->withFailed('measurment not updated');
            }
            return redirect()->back()->withFailed('measurment not found');
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
        );
        
        $this->validate($request, $rules);
        try{
            $measurs = Measurment::create([
                'name'=> $request->name,
            ]);
            if($measurs)
            {
                return redirect('/measurment')->with('success','measurment successfully created');
            }
            return redirect()->back()->withFailed('measurment not created');
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
            $measurs = Measurment::find($id);
            if($measurs)
            {
                $measurs->delete();
                return redirect()->back()->withSuccess('Measurment successfully deleted');
            }
        }
        return redirect()->back()->withFailed('Measurment not found');
    }
}
