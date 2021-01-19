<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailResetNotification;

class EmailReset extends Model
{
	use Notifiable;

	protected $fillable = [
		'user_id',
		'new_email',
		'token',
	];
	public function sendEmailResetNotification($token)
	{
		$this->notify(new EmailResetNotification($token));
	}
	public function routeNotificationForMail()
	{
		return $this->new_email;
	}
}
