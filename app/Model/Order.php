<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use Notifiable;

    public function get()
    {
        return DB::table('orders')->get();
    }

    public function getOrders()
    {
        return DB::table('orders')->orderBy('updated_at','ASC')->get();
    }

    public function add($data)
    {
        return DB::table('orders')->insert($data);
    }

    public function getOrderByCode($code)
    {
        return DB::table('orders')->where('code', '=', $code)->first();
    }

    public function cancelOrder($id)
    {
        return DB::table('orders')->where('id',$id)->update(['cancel'=>1]);
    }

    public function getUserByOrder($id)
    {
        return DB::table('users')->where('id',$id)->first();
    }
}
