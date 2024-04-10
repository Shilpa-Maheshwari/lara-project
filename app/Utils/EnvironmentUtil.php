<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class EnvironmentUtil
{
    public static function isProduction()
	{
		return false;
	}
}
