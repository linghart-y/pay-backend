<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function remittances()
    {
    	$user = auth()->user();
    	$remittances = $user->remittances;
    	return $remittances;
    }

    public function in_remittances()
    {
    	$user = auth()->user();
    	$remittances = $user->in_remittances;
    	return $remittances;
    }

    public function out_remittances()
    {
    	$user = auth()->user();
    	$remittances = $user->out_remittances;
    	return $remittances;
    }

    public function getPersons()
    {
        $user = auth()->user();
        $users = User::all()->transform(function($person){
                return [
                    'id' => $person->id,
                    'name' => $person->first_name . ' ' . $person->last_name,
                ];
            });
        return $users;
    }

    public function getAllRemittances(Request $request)
    {
        $user = auth()->user();
        $in = $user->in_remittances;
        $out = $user->out_remittances;
        $result = $out->merge($in);
        return $result->transform(function($remittance) use ($user){
            return [
                'id' => $remittance->id,
                'type' => $user->id == $remittance->sender->id ? 'Out' : 'In',
                'sender' => $remittance->sender->first_name . ' ' . $remittance->sender->last_name,
                'recipient' => $remittance->recipient->first_name . ' ' . $remittance->recipient->last_name,
                'value' => $remittance->value,
                'created_at' => $remittance->created_at->format("Y-m-d H:i:s"),
            ];
        });
    }

}
