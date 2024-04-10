<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Config;
use App\Traits\CustomTraits;
use App\Models\PanVerificationReport;
use App\Utils\EnvironmentUtil;
use Exception;
use Illuminate\Support\Facades\Log;

class PanVerificationService
{
    use CustomTraits;
    public function panVerification($pancard)
    {
        $check= PanVerificationReport::where('pan',$pancard)->first();
        if($check)
        {
            return json_encode(['status' => 1, 'message' => "PAN verification successfully", 'name' => $check->pan_holder_name,'txnId' => $check->txn_unique_id, 'bankRef' => $check->txn_unique_id ]);
        }
        $report = PanVerificationReport::create(['pan' => $pancard]);
        $report->txn_unique_id = $pancard . $report->id;
        $report->ackno = date("YmdHis").$this->getfiveChar();
        $report->save();

        $dataToPost=array(
            'api_token'=>config('constants.ATOZ_API_KEY'),
            'userId'=> config('constants.ATOZ_USER_ID'),
            'secretKey'=>config('constants.ATOZ_SECRET_KEY'),
            'clientId'=>$report->ackno,
            'panNumber'=>$pancard,
        );
        $report->request = json_encode($dataToPost);
        $report->save();
        if(EnvironmentUtil::isProduction()) {
            $url = config('constants.ATOZ_BASE_URL') . "/api/v3/pan-verification";
            $log = "\n**************** URL **************\n";
            $log .= $url;
            $log .= "\n------------ Date to be posted ----------------\n";
            $log .= json_encode($dataToPost);
            Log::channel('pan_verification_log')->info($log);

            $apiResp = $this->getCurlPostMethod($url, $dataToPost);
            $log = "\n------------ Response ----------------\n";
            $log .= $apiResp;
            Log::channel('pan_verification_log')->info($log);
        } else {
            $apiResp ='{"status": 1,"message":"Pancard successfull verified","name":"Rajkumar Rankawat","clientId":"145545","txnId":"TXN1254"}';
        }
        $report->response = $apiResp;
        $report->save();
        try{
            $apiJsonObject = json_decode($apiResp);

            $status = $apiJsonObject->status;
            $orderId = $externalId = $apiJsonObject->txnId;

            if($status == 1) 
            {
                $report->pan_holder_name = $apiJsonObject->name;
                $report->pan_status = 1;
                $report->txn_unique_id=$apiJsonObject->txnId;
                $report->save();

                return json_encode(['status' => 1, 'message' => "PAN verification successfully", 'name' => $report->pan_holder_name,'txnId' => $orderId, 'bankRef' => $externalId]);
            } 
            elseif(in_array($status,array(2,401,8001,26,78,100,101,102,103,401,500))) 
            {
                $report->pan_status = 2;
                $report->save();

                return json_encode(['status'=>2,'message'=>$status,'name'=>'','txnId'=>$orderId,'bankRef'=>'',"message"=>$apiJsonObject->message]);
            }
            return json_encode(['status'=>3,'message'=>"PAN verification pending",'name'=>'','txnId'=>$orderId,'bankRef'=>'']);
        }
        catch(Exception $e)
        {
            return json_encode(['status'=>3,'message'=>"PAN verification pending",'name'=>'','txnId'=>'','bankRef'=>'']);
        }
    }
}
