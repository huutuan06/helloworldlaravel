<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use Notifiable;

    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    public function add($data)
    {
        return DB::table('books')->insert($data);
    }

    public function get()
    {
        return DB::table('books')->get();
    }

    public function getByTitle($title)
    {
        return DB::table('books')->where('title', $title)->first();
    }

    public function deleteById($id)
    {
        return DB::table('books')->where('id', $id)->delete();
    }

    public function getById($id)
    {
        return DB::table('books')->where('id', $id)->first();
    }

    public function updateById($id, $data)
    {
        return DB::table('books')->where('id', $id)->update(['title' => $data['title'], 'image' => $data->image, 'description' => $data['description'], 'total_pages' => $data['total_pages'], 'price' => $data['price']]);
    }
}
