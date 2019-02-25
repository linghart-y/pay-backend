<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Remittance;
class AdminController extends Controller
{
	public function ban(Request $request)
	{
		$user = User::findOrFail($request->id);
		$user->ban = true;
		$user->save();
		return ['status'=>'success'];
	}

	public function unban(Request $request)
	{
		$user = User::findOrFail($request->id);
		$user->ban = false;
		$user->save();
		return ['status'=>'success'];
	}

    public function usersIndex()
    {
    	$users = User::all();
    	return $users;
    }

    public function remittanceIndex()
    {
    	$remittances = Remittance::all();
    	$remittances->load('sender', 'recipient');
    	return $remittances->transform(function($payment){
            return [
                'id' => $payment->id,
                'value' => $payment->value,
                'sender' => $payment->sender->first_name . ' ' . $payment->sender->last_name, 
                'recipient' => $payment->recipient->first_name . ' ' . $payment->recipient->last_name,
                'created_at' => $payment->created_at->format("Y-m-d H:i:s"),
            ];
        });
    }

    public function getPerson(Request $request)
    {
    	$person = User::findOrFail($request->id);
    	return $person;
    }

    public function getPayment(Request $request)
    {
    	$payment = Remittance::findOrFail($request->id);
    	$payment->load('sender', 'recipient');
    	return [
            'id' => $payment->id,
            'value' => $payment->value,
            'sender_id' => $payment->sender->id, 
            'sender_name' => $payment->sender->first_name . ' ' . $payment->sender->last_name, 
            'recipient_name' => $payment->recipient->first_name . ' ' . $payment->recipient->last_name,
            'recipient_id' => $payment->recipient->id,
            'created_at' => $payment->created_at->format("Y-m-d H:i:s"),
        ];
    }

    public function savePayment(Request $request)
    {
    	$payment = Remittance::findOrFail($request->payment['id']);
    	$payment->value = $request->payment['value'];
    	$payment->sender_id = $request->payment['sender_id'];
    	$payment->recipient_id = $request->payment['recipient_id'];
    	$payment->save();
    	return ['status'=>'success'];
    }

    public function saveUser(Request $request)
    {
	    $user = User::findOrFail($request->user['id']);
	    $user->username = $request->user['username'];
	    $user->first_name = $request->user['first_name'];
	    $user->last_name = $request->user['last_name'];
	    $user->email = $request->user['email'];
	    if ($request->password)
	      $user->password = bcrypt($request->password);

	    try {
	          $user->save();
	        return "Ok";
	    } catch (\Illuminate\Database\QueryException $exception){
	        return response()->json(['error' => $exception->errorInfo[2]], 404);
	    }
    }

}
