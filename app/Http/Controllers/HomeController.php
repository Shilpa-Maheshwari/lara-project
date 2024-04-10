<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Utils\ValidationUtil;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class HomeController extends Controller
{
    //login page
    public function loginpage()
    {
        //echo Hash::make('shilpa@1234'); die;
        return view('site.login_page');
    }
    public function register_view()
    {
        dd($now = now());
        $user = User::find(2);
        dd($user->name);
        //dd($user);
        return view('site.register_page');
    }
    public function dashboard()
    {
        return view('/dashboard');
    }
    public function singin(Request $request)
    {

        $rules=[
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:8',
            'confirm_password'=>'required_with:password|same:password|min:8',
        ];

        $validator  = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return redirect('/register_page')->withSuccess('User Not Created.');
        }
        $res = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        if($res)
        {
            return redirect('/dashboard')->withSuccess('User Created.');
        }
        return redirect()->back()->withFailed('User Not Create.');
    }


    public function createAccount(Request $request)
    {

        //dd($request->all());
        $rules=[
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:8',
            'confirm_password'=>'required_with:password|same:password|min:8',
        ];
        $validator  = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return response()->json([
                'status'=>"0",
                'message'=>ValidationUtil::errorsInPlainText($validator)
            ]);
        }
       $res = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        if($res)
        {
            return redirect('/dashboard')->withSuccess('User Created.');
        }
        return redirect()->back()->withFailed('User Not Create.');
    }
    public function login(Request $request)
    {
        dd($request); die;
        $rules=[
            'email'=>'required',
            'password'=>'required|min:8',
        ];
        $this->validate($request, $rules);
        $row = User::Where('email', $request->email)->first();
        if($row)
        {
            if(Hash::check($request->password, $row->password))
            {
                $creditionals=$request->only(['email','password']);

                if(Auth::attempt($creditionals))
                {
                    return redirect('/dashboard');
                }
                return redirect()->back()->withFailed('Invalid Creditionals');

            }else{
                return redirect()->back()->withFailed('password is wrong');
            }
        }
        return redirect()->back()->withFailed('Email not exist');
    }

}
