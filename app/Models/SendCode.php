<?php 

namespace App\Models;
use function app;

Class SendCode{
	public static function sendCode($user)
	{
		$code=$user->pin_code;
		$nexmo=app('Nexmo\Client');
		$nexmo->message()->send([

				'to'=>'+880'.(int)$user->phone,
				'from'=>'8801913228046',
				'text'=>'Verify Code:'. $code,
			]);
		return $code;
	}
}