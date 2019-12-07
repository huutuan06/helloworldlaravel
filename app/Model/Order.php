<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use Notifiable;

    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    public function get()
    {
        return DB::table('orders')->get();
    }

    public function getById($id)
    {
        return DB::table('orders')->where('id', '=', $id)->first();
    }

    public function getUserByOrder($user_id)
    {
        return DB::table('users')->where('id', '=', $user_id)->first();
    }

}
