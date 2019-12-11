<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Book_Order extends Model
{
    use Notifiable;

    public function get($order_id)
    {
        return DB::table('book_order')
            ->where('order_id', $order_id)
            ->get();
    }
}
