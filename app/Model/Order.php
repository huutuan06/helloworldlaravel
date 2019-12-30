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

    public function getOrderById($id) {
        return DB::table('orders')->where('id', $id)->first();
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

    public function updateById($id, $data)
    {
        \Log::info($data);
        return DB::table('orders')->where('id', $id)->update([
            'id' => $data[0]['id'],
            'code' => $data[0]['code'],
            'user_id' => $data[0]['user_id'],
            'address' => $data[0]['address'],
            'payment' => $data[0]['payment'],
            'confirmed_ordering' => $data[0]['confirmed_ordering'],
            'unsuccessful_payment' => $data[0]['unsuccessful_payment'],
            'delivery' => $data[0]['delivery'],
            'success' => $data[0]['success'],
            'cancel' => $data[0]['cancel'],
            'created_at' => $data[0]['created_at'],
            'updated_at' => $data[0]['updated_at']
        ]);
    }
}
