<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
 
class DateUtil 
{
   public static function fromdate($date=null)
   {
     
    $start_date =($date) ? $date ." 00:00:00" : date("Y-m-d") . " 00:00:00";
    return  date("Y-m-d H:i:s", strtotime($start_date));

   }
   public static function todate($date=null)
   {
  
    $end_date = ($date) ? $date ." 23:59:59" : date("Y-m-d H:i:s");
    return date("Y-m-d H:i:s", strtotime($end_date));
   }
}
