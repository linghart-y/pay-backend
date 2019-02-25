<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Remittance extends Model
{
    public static function boot() {
    	parent::boot();
	    static::created(function (Remittance $remittance) {
	        $sender = User::findOrFail($remittance->sender_id);
	        $recipient = User::findOrFail($remittance->recipient_id);
	        $recipient->balance += $remittance->value;
	        if($remittance->sender_id != 1){
	        	$sender->balance = $sender->balance - $remittance->value;
	        }
	        $recipient->save();
	        $sender->save();
	    });
    }

    public function sender()
    {
    	return $this->belongsTo('App\User', 'sender_id');
    }

    public function recipient()
    {
    	return $this->belongsTo('App\User', 'recipient_id');
    }
}
