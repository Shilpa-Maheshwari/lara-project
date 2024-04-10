<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class SmsUtil
{
	public static function selfPortalSms($mobile,$message)
	{

	}
	public static function mobileVerification($mobile,$otp)
	{

		$message="Dear Partner, ". strtoupper(Config::get('constants.SITE_NAME')) ." Registration verification OTP : $otp ".config('constants.THANKS_WORD'). ' on ' . date("Y-m-d H:i:s").".";
		try{
			return SmsUtil::selfPortalSms($mobile,$message);
		}catch(Exception $e){
			Log::channel('sms_log')->debug("SMS ERROR".$e);
		}
	}
}