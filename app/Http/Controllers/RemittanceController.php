<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Remittance;
use App\User;
class RemittanceController extends Controller
{
   
    public function addRemittance(Request $request)
    {
    	list($first_name, $last_name) = explode(" ", $request->recipient_name);
    	$recipient = User::where('first_name', $first_name)->where('last_name', $last_name)->first();
    	$remittance = new Remittance();
    	     $remittance->recipient_id = $recipient->id;
    	     $remittance->sender_id = auth()->user()->id;
    	     $remittance->value = $request->value;
     	$remittance->save();
     	return ['status'=>'success'];
    }

    public function fromTemplate(Request $request)
    {
    	$remittance = Remittance::findOrFail($request->id);
  
    	return [
    		'value'=>$remittance->value,
    		'sender'=>$remittance->sender->first_name . ' ' . $remittance->sender->last_name,
    		'recipient'=>$remittance->recipient->first_name . ' ' . $remittance->recipient->last_name,
    	];
    }

}
