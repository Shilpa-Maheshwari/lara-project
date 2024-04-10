<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use App\Models\Verification;
use App\Models\Registration;
use App\Models\User;
use App\Models\Profile;

use App\Services\PanVerificationService;

use App\Utils\EnvironmentUtil;
use App\Utils\SmsUtil;
use App\Traits\CustomTraits;

use Exception;

class RegistrationService
{
    use CustomTraits; 

    public function mobileProcess($mobile_no)
    {
        $isMobileExist = Registration::where('mobile_no',$mobile_no)->first();
        
		if($isMobileExist)
		{
   
            $userDetails = array(						
                'name'=>$isMobileExist->name,
                'mobileNumber'=>(String) $isMobileExist->mobile_no,
                'email'=>$isMobileExist->email,
                'pan'=> $isMobileExist->pan,
                'aadhar'=> (String) $isMobileExist->aadhar,
                'isMobileVerified'=>$isMobileExist->is_mobile_verified,
                'isEmailVerified'=>$isMobileExist->is_email_verified,
                'isPanVerified'=>$isMobileExist->is_pan_verified,
            );

            if($isMobileExist->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $isMobileExist->id,	
                    'message'=>"Mobile Number already exist",
                ]);
			}
            if($isMobileExist->is_mobile_verified =='1')
			{
                $NextMessage = "Mobile verification complete";

                $panVerification= Verification::where(['type'=>'pan','status_id'=>'1'])->first();
                $emailVerification= Verification::where(['type'=>'email','status_id'=>'1'])->first();
                
                $userDetails['skip']=[
                    'pan'=>$panVerification ? '1':'0', 
                    'email'=>$emailVerification ? '1':'0', 
                ];

                if($emailVerification)
                {
                    if($isMobileExist->email)
                    {
                        if($isMobileExist->is_email_verified=='0')
                        {
                            $otp = $this->generateSixDigitOtp();
                            $isMobileExist->email_otp = $otp;

                            if($isMobileExist->email_otp_counter>3)
                                $isMobileExist->email_otp_counter =0;

                            $isMobileExist->email_otp_counter +=1;
                            $isMobileExist->last_sent_email_otp =date("Y-m-d H:i:s");
                            $isMobileExist->save();
                            if(EnvironmentUtil::isProduction())
                            {

                            }
                            else
                            {
                                $isMobileExist->email_otp = 100100;
                                $isMobileExist->save();
                            }
                            return json_encode([
                                'status'=>"3",
                                'requestId'=>(String) $isMobileExist->id,	
                                'message'=>"OTP sent at email address",
                                'details'=>$userDetails
                            ]);
                        }
                        else
                        {
                            $NextMessage = "Email verification complete";
                        }
                    }else{
                        return json_encode([
                            'status'=>"2",
                            'requestId'=>(String) $isMobileExist->id,	
                            'message'=>$NextMessage.". Please register email address",
                            'details'=>$userDetails
                        ]);
                    }
                }

                if($panVerification)
                {
                    if($isMobileExist->is_pan_verified=='0')
                    {
                        return json_encode([
                            'status'=>"4",
                            'requestId'=>(String) $isMobileExist->id,	
                            'message'=>$NextMessage.". Please register pan number",
                            'details'=>$userDetails
                        ]);
                    }else{
                        $NextMessage = "Pan verification complete";
                    }
                }

                if($isMobileExist->is_registration_complete=='0')
                {
                    return json_encode([
                        'status'=>"9",
                        'requestId'=>(String) $isMobileExist->id,	
                        'message'=>$NextMessage.". Please create account details.",
                        'details'=>$userDetails
                    ]);
                }
                   
            }

            $otp = $this->generateSixDigitOtp();
            $isMobileExist->mobile_otp = $otp;
            
            if($isMobileExist->mobile_otp_counter>3)
                $isMobileExist->mobile_otp_counter =0;
            
            $isMobileExist->mobile_otp_counter +=1;
            $isMobileExist->last_sent_mobile_otp =	date("Y-m-d H:i:s");
            $isMobileExist->save();

            if(EnvironmentUtil::isProduction()){
                SmsUtil::mobileVerification($mobile_no,$otp);
            }else{
                $isMobileExist->mobile_otp = 100100;
                $isMobileExist->save();
            }
            return json_encode([
                'status'=>"1",
                'requestId'=>(String) $isMobileExist->id,	
                'message'=>"OTP sent at mobile number",
            ]);
        }
        else
        {
            $otp = $this->generateSixDigitOtp();

            if(EnvironmentUtil::isProduction()){
                SmsUtil::mobileVerification($mobile_no,$otp);
            }else{
                $otp="100100";
            }
            
            $details=Registration::create(['mobile_no'=>$mobile_no, 'mobile_otp'=>$otp]);
            
            return json_encode([
                'status'=>"1",
                'requestId'=>(String) $details->id,	
                'message'=>"OTP sent at mobile number",
            ]);
        }
    }

    public function mobileVerification($id, $otp)
    {
        $isMobileExist = Registration::where(['id'=>$id])->first();
		if($isMobileExist)
		{
            if($isMobileExist->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $isMobileExist->id,	
                    'message'=>"Mobile Number already exist",
                ]);
			}
            
            if($isMobileExist->mobile_otp == $otp)
            {
                $isMobileExist->is_mobile_verified='1';
                $isMobileExist->save();

                $panVerification= Verification::where(['type'=>'pan','status_id'=>'1'])->first();
                $emailVerification= Verification::where(['type'=>'email','status_id'=>'1'])->first();

                $userDetails = array(						
                    'name'=>$isMobileExist->name?$isMobileExist->name:'',
                    'mobileNumber'=>(String) $isMobileExist->mobile_no,
                    'email'=>$isMobileExist->email?$isMobileExist->email:'',
                    'pan'=> $isMobileExist->pan?$isMobileExist->pan:'',

                    'skip'=>[
                        'pan'=>$panVerification ? '1':'0', 
                        'email'=>$emailVerification ? '1':'0', 
                    ]
                );
                $NextMessage="Please create account details";
                $status="9";
                if($emailVerification){
                    $status="1";
                    $NextMessage="Please register email address";
                }else if($panVerification){
                    $status="4";
                    $NextMessage="Please register pan number";
                }

                return json_encode([
                    'status'=>$status,
                    'requestId'=>(String) $isMobileExist->id,	
                    'message'=>"Mobile verification complete. ".$NextMessage,
                    'details'=>$userDetails
                ]);
            }
            return json_encode([
                'status'=>"2",
                'requestId'=>(String) $isMobileExist->id,	
                'message'=>"Invalid Otp Code",
            ]);
        }
        else
        {
            return json_encode([
                'status'=>"0",
                'message'=>"Invalid Request",
            ]);
        }
    }

    public function emailProcess($id, $email)
    {
        $isEmailExist = Registration::find($id);
		if($isEmailExist)
		{
            $userDetails = array(						
                'name'=>$isEmailExist->name,
                'mobileNumber'=>(String) $isEmailExist->mobile_no,
                'email'=>$isEmailExist->email,
                'pan'=> $isEmailExist->pan,

                'isMobileVerified'=>$isEmailExist->is_mobile_verified,
                'isEmailVerified'=>$isEmailExist->is_email_verified,
                'isPanVerified'=>$isEmailExist->is_pan_verified,
            );
            if($isEmailExist->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $isEmailExist->id,	
                    'message'=>"Email Address already exist",
                ]);
			}
			if($isEmailExist->is_mobile_verified =='1')
			{
                if($isEmailExist->email)
                {
                    if($isEmailExist->is_email_verified=='1')
                    {
                        $NextMessage='Email verification complete';
                        $panVerification= Verification::where(['type'=>'pan','status_id'=>'1'])->first();
                        if($panVerification)
                        {
                            if($isEmailExist->is_pan_verified=='0')
                            {
                                return json_encode([
                                    'status'=>"4",
                                    'requestId'=>(String) $isEmailExist->id,	
                                    'message'=>$NextMessage.". Please register pan number",
                                    'details'=>$userDetails
                                ]);
                            }else{
                                $NextMessage="Pan verification complete";
                            }
                        }
                        
                        if($isEmailExist->is_registration_complete=='0')
                        {
                            return json_encode([
                                'status'=>"9",
                                'requestId'=>(String) $isEmailExist->id,	
                                'message'=>$NextMessage.". Please create your account creditionals",
                                'details'=>$userDetails
                            ]);
                        }
                    }
                    $otp = $this->generateSixDigitOtp();
                    $isEmailExist->email_otp = $otp;

                    if($isEmailExist->email_otp_counter>3)
                        $isEmailExist->email_otp_counter =0;

                    $isEmailExist->email_otp_counter +=1;
                    $isEmailExist->last_sent_email_otp =	date("Y-m-d H:i:s");
                    $isEmailExist->save();

                    if(EnvironmentUtil::isProduction())
                    {
                        
                    }
                    else
                    {
                        $isEmailExist->email_otp = 100100;
                        $isEmailExist->save();
                    }
                    return json_encode([
                        'status'=>"1",
                        'requestId'=>(String) $isEmailExist->id,	
                        'message'=>"OTP sent at Email Address",
                    ]);
                }
                $otp = $this->generateSixDigitOtp();
                $isEmailExist->email = $email;
                $isEmailExist->email_otp = $otp;

                if($isEmailExist->email_otp_counter>3)
                    $isEmailExist->email_otp_counter =0;

                $isEmailExist->email_otp_counter +=1;
                $isEmailExist->last_sent_email_otp =	date("Y-m-d H:i:s");
                $isEmailExist->save();

                if(EnvironmentUtil::isProduction())
                {
                    
                }
                else
                {
                    $isEmailExist->email_otp = 100100;
                    $isEmailExist->save();
                }
                return json_encode([
                    'status'=>"1",
                    'requestId'=>(String) $isEmailExist->id,	
                    'message'=>"OTP sent at Email Address",
                ]);
            }
            else
            {
                return json_encode([
                    'status'=>"0",
                    'message'=>"Mobile Number not verified",
                ]);
            }
        }
        else
        {
            return json_encode([
                'status'=>"0",
                'message'=>"Invalid Request",
            ]);
        }
    }
    
    public function emailVerification($id, $otp)
    {
        $isEmailExist = Registration::where(['id'=>$id])->first();
		if($isEmailExist)
		{
            if($isEmailExist->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $isEmailExist->id,	
                    'message'=>"Email address already exist",
                ]);
			}
            if($isEmailExist->email_otp == $otp)
            {
                $isEmailExist->is_email_verified='1';
                $isEmailExist->save();
                
                $userDetails = array(						
                    'name'=>$isEmailExist->name,
                    'mobileNumber'=>(String) $isEmailExist->mobile_no,
                    'email'=>$isEmailExist->email,
                    'pan'=> $isEmailExist->pan,
                );

                $NextMessage= "Email verification complete";

                $panVerification= Verification::where(['type'=>'pan','status_id'=>'1'])->first();
                if($panVerification)
                {
                    if($isEmailExist->is_pan_verified=='0')
                    {
                        return json_encode([
                            'status'=>"4",
                            'requestId'=>(String) $isEmailExist->id,	
                            'message'=>$NextMessage.". Please register pan number",
                            'details'=>$userDetails
                        ]);
                    }else{
                        $NextMessage= "Pan verification complete";
                    }
                }
               
                return json_encode([
                    'status'=>"1",
                    'requestId'=>(String) $isEmailExist->id,	
                    'message'=>$NextMessage.". Please create account details",
                    'details'=>$userDetails
                ]);
            }
            return json_encode([
                'status'=>"2",
                'requestId'=>(String) $isEmailExist->id,	
                'message'=>"Invalid Otp Code",
            ]);
        }
        else
        {
            return json_encode([
                'status'=>"0",
                'message'=>"Invalid Request",
            ]);
        }
    }
    
    public function panVerification($id, $pan)
    {
        $isRowExist = Registration::find($id);
		if($isRowExist)
		{
            $userDetails = array(						
                'name'=>$isRowExist->name,
                'mobileNumber'=>(String) $isRowExist->mobile_no,
                'email'=>$isRowExist->email,
                'pan'=> $isRowExist->pan,

                'isMobileVerified'=>$isRowExist->is_mobile_verified,
                'isEmailVerified'=>$isRowExist->is_email_verified,
                'isPanVerified'=>$isRowExist->is_pan_verified,
            );
            if($isRowExist->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $isRowExist->id,	
                    'message'=>"Pan already exist",
                ]);
			}
            if($isRowExist->is_mobile_verified=='1')
            {
                $emailVerification= Verification::where(['type'=>'email','status_id'=>'1'])->first();
                if($emailVerification)
                {
                    if($isRowExist->is_email_verified!='1')
                    {
                        return json_encode([
                            'status'=>"1",
                            'requestId'=>(String) $isRowExist->id,	
                            'message'=>"Please register your email address",
                            'details'=>$userDetails
                        ]);
                    }
                }
                if($isRowExist->is_pan_verified=='1')
                {
                    $NextMessage="Pan verification complete";
                    
                    return json_encode([
                        'status'=>"1",
                        'requestId'=>(String) $isRowExist->id,	
                        'message'=>$NextMessage.". Please create account details",
                        'details'=>$userDetails
                    ]);
                }
                $isRowExist->pan = $pan;
                $isRowExist->save();
                
                try{
                    $result = json_decode( (new PanVerificationService())->panVerification($pan) );
                    if($result->status==1)
                    {
                        $isRowExist->name=$result->name;
                        $isRowExist->is_pan_verified='1';
                        $isRowExist->save();
                        
                        $userDetails = array(						
                            'name'=>$isRowExist->name,
                            'mobileNumber'=>(String) $isRowExist->mobile_no,
                            'email'=>$isRowExist->email,
                            'pan'=> $isRowExist->pan,
            
                            'isMobileVerified'=>$isRowExist->is_mobile_verified,
                            'isEmailVerified'=>$isRowExist->is_email_verified,
                            'isPanVerified'=>$isRowExist->is_pan_verified,
                        );
                        $NextMessage="Pan verification complete";


                        return json_encode([
                            'status'=>"1",
                            'message'=>$NextMessage.'. Please create account details',
                            'requestId'=>(String) $isRowExist->id,
                            'details'=>$userDetails
                        ]);
                    }
                    else
                    {
                        return json_encode([
                            'status'=>"0",
                            'requestId'=>(String) $isRowExist->id,	
                            'message'=>"Invalid Pan request.",
                            'req'=>$result
                        ]);
                    }
                }
                catch(Exception $e)
                {
                    return json_encode([
                        'status'=>"0",
                        'requestId'=>(String) $isRowExist->id,	
                        'message'=>$e->getMessage(),
                    ]);
                }
            }
            return json_encode([
                'status'=>"0",
                'requestId'=>(String) $isRowExist->id,	
                'message'=>"Mobile Number not verified",
            ]);
        }
        return json_encode([
            'status'=>"0",
            'requestId'=>(String) $isRowExist->id,	
            'message'=>"Invalid Request",
        ]);
    }
    
    public function signup($id, $password, $latitude, $longitude)
    { 
        $row = Registration::find($id);
        if($row)
        {
            $user =[
                'name'=>$row->name ? $row->name : '',
                'email'=>$row->email ? $row->email : '',
                'password'=>Hash::make($password),
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'role_id'=>2
            ];
            if($row->is_registration_complete=='1')
			{
				return json_encode([
                    'status'=>"10",
                    'requestId'=>(String) $row->id,	
                    'message'=>"User already registered.",
                ]);
			}
            if($user = User::create($user))
            {
                if($user->save()){
                    $row->is_registration_complete='1';
                    $row->save();

                    if($profile = Profile::create(['user_id'=>$user->id])){
                        $user->profile_id= $profile->id;
                        $user->save();
                    }
                }

                return json_encode(['status'=>1, 'message'=>'User successfully registered']);
            }
            return json_encode(['status'=>0, 'message'=>'User not registered yet']);
        }
        return json_encode(['status'=>0, 'message'=>'Invalid Request']);   
    }
}