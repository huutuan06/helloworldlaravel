<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use Notifiable;

    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    public function add($data) {
        return DB::table('books')->insert($data);
    }

    public function get() {
        return DB::table('books')->get();
    }

    public function getByName($name) {
        return DB::table('books')->where('name',$name)->first();
    }
}
