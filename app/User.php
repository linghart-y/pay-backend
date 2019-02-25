<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Remittance;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public static function boot() {
        parent::boot();
        static::created(function (User $user) {
            $remittance = new Remittance();
                $remittance->sender_id = 1;
                $remittance->recipient_id = $user->id;
                $remittance->value = 500;
            $remittance->save();
        });
    }
    //protected $primaryKey = 'userid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function in_remittances()
    {
        return $this->hasMany('App\Remittance', 'recipient_id', 'id');
    }

    public function out_remittances()
    {
        return $this->hasMany('App\Remittance', 'sender_id', 'id');
    }

    public function remittances()
    {
        $in = $this->in_remittances;
        $out = $this->out_remittances;
        return $in->merge($out);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
