<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     * You can manually set this using Laravel, just remember to add 'created_at' to your $fillable array
     * and $timestamps = true; work and fill created_at and updated_at
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_verified', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isEmailExisted($email) {
        return DB::table('users')->where('email', '=', $email)->first() != null;
    }

    public function add($data) {
        return DB::table('users')->insert($data);
    }

    public function getByEmail($email) {
        return DB::table('users')->where('email', '=', $email)->first();
    }

    public function get() {
        return DB::table('users')->get();
    }

    public function getById($id) {
        return DB::table('users')->where('id', '=', $id)->first();
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
