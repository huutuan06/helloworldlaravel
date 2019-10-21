<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use Notifiable;

    protected $table = "categories";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('categories')->insert($data);
    }
    public function getAll(){
        return DB::table('categories')->get();
    }
}
