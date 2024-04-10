<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
 
class ValidationUtil 
{
  public static function errorsInPlainText($validation)
	{
		$validation = $validation->getMessageBag()->toArray();
    $missionString='';
    foreach($validation as $info)
    {
      $missionString = ($missionString) ?  ($missionString.','.$info['0'] ): $info['0'];
    }
    return "Invalid Request Data -  ". $missionString;
	}
}
