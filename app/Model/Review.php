<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    use Notifiable;

    protected $table = "reviews";

    public function add($data) {
        return DB::table('reviews')->insert($data);
    }

    public function get() {
        return DB::table('reviews')->get();
    }

    public function getByBookID($book_id) {
        return DB::table('reviews')->where('book_id', $book_id)->get();
    }
}
