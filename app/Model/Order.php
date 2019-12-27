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

    public function add($data)
    {
        return DB::table('orders')->insert($data);
    }

    public function getLastOrder()
    {
        return DB::table('orders')->orderBy('created_At', 'desc')->first();
    }
}
