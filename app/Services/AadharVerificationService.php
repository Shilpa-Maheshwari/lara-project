<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Config;
use App\Traits\CustomTraits;
use App\Models\PanVerificationReport;
use App\Utils\EnvironmentUtil;
use Exception;
use Illuminate\Support\Facades\Log;

class AadharVerificationService
{
    use CustomTraits;
    public function aadharVerification($aadharcard)
    {

        $dataToPost=array(
            'api_token'=>config('constants.ATOZ_API_KEY'),
            'userId'=> config('constants.ATOZ_USER_ID'),
            'secretKey'=>config('constants.ATOZ_SECRET_KEY'),
            'aadharNumber'=>$aadharcard,
        );
        if(EnvironmentUtil::isProduction()) {
            $url = config('constants.ATOZ_BASE_URL') . "/api/v3/aadhar-verification";
            $log = "\n**************** URL **************\n";
            $log .= $url;
            $log .= "\n------------ Date to be posted ----------------\n";
            $log .= json_encode($dataToPost);
            Log::channel('aadhar_verification_log')->info($log);

            $apiResp = $this->getCurlPostMethod($url, $dataToPost);
            $log = "\n------------ Response ----------------\n";
            $log .= $apiResp;
            Log::channel('aadhar_verification_log')->info($log);
        } else {
            $apiResp ='{"status": 1,"message":"Aadhar number successfull verified","name":"Rajkumar Rankawat","clientId":"145545","txnId":"TXN1254"}';
        }
        try{
            $apiJsonObject = json_decode($apiResp);

            $status = $apiJsonObject->status;
            $orderId = $externalId = $apiJsonObject->txnId;

            if($status == 1) 
            {
                return json_encode(['status' => 1, 'message' => "Aadhar verification successfully", 'txnId' => $orderId, 'bankRef' => $externalId]);
            } 
            elseif(in_array($status,array(2,401,8001,26,78,100,101,102,103,401,500))) 
            {
                return json_encode(['status'=>2,'message'=>$status,'name'=>'','txnId'=>$orderId,'bankRef'=>'',"message"=>$apiJsonObject->message]);
            }
            return json_encode(['status'=>3,'message'=>"Aadhar verification pending",'name'=>'','txnId'=>$orderId,'bankRef'=>'']);
        }
        catch(Exception $e)
        {
            return json_encode(['status'=>3,'message'=>"Aadhar verification pending",'name'=>'','txnId'=>'','bankRef'=>'']);
        }
    }
}
