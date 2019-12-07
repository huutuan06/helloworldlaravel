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

    /**
     * Get User from DB by attribute ID
     * @param $id
     * @return mixed
     */
    public function getById($id) {
        return DB::table('users')->where('id', '=', $id)->first();
    }

    /**
     * Get User from DB by attribute Email
     * @param $email
     * @return mixed
     */
    public function getByEmail($email) {
        return DB::table('users')->where('email', '=', $email)->first();
    }

    /**
     * Delete User from DB by attribute ID
     * @param $id
     * @return mixed
     */
    public function deleteById($id) {
        return DB::table('users')->where('id', $id)->delete();
    }

    /**
     * Get all customers from DB (type = null)
     * @return mixed
     */
    public function getAllCustomers() {
        return DB::table('users')->where('type', null)->get();
    }














    public function add($data) {
        return DB::table('users')->insert($data);
    }

    public function get() {
        return DB::table('users')->get();
    }

    public function getByName($name) {
        return DB::table('users')->where('name', '=', $name)->first();
    }

    public function updateById($id, $data)
    {
        return DB::table('users')->where('id', $id)->update(['name' => $data['name'], 'password' => $data->password, 'phone_number' => $data->phone_number,
            'date_of_birth' => $data['date_of_birth'], 'gender' => $data['gender'], 'avatar' => $data->avatar, 'address'=> $data['address']]);
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
