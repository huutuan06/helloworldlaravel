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

    protected $primaryKey = 'id';

    public $autoincrement = false;

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

    public function getByTitlenAuthor($title, $price)
    {
        return DB::table('books')
            ->where('title', $title)
            ->where('price', $price)
            ->first();
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
        return DB::table('books')->where('id', $id)->update([
            'id' => $data[0]['id'],
            'title' => $data[0]['title'],
            'numeral' => $data[0]['numeral'],
            'image' => $data[0]['image'],
            'category_id' => $data[0]['category_id'],
            'description' => $data[0]['description'],
            'total_pages' => $data[0]['total_pages'],
            'price' => $data[0]['price'],
            'amount' => $data[0]['amount'],
            'author' => $data[0]['author']
        ]);
    }

    public function getCategoryById($id)
    {
        return DB::table('categories')->where('id', $id)->first();
    }

    public function getByCategory($id)
    {
        return DB::table('books')->where('category_id', $id)->get();
    }

    public function getAllCategories() {
        return DB::table('categories')->get();
    }

    public function synchWithServerFromLocal($book) {
        if ($this->getByTitlenAuthor($book['title'], $book['price']) != null)
            $this->updateById($this->getByTitlenAuthor($book['title'], $book['author'])->id, array([
                'id' => $this->getByTitlenAuthor($book['title'], $book['author'])->id,
                'title' => $this->getByTitlenAuthor($book['title'], $book['author'])->title,
                'numeral' => $this->getByTitlenAuthor($book['title'], $book['author'])->id,
                'image' => $this->getByTitlenAuthor($book['title'], $book['author'])->image,
                'category_id' => $this->getByTitlenAuthor($book['title'], $book['author'])->category_id,
                'description' => $this->getByTitlenAuthor($book['title'], $book['author'])->description,
                'total_pages' => $this->getByTitlenAuthor($book['title'], $book['author'])->total_pages,
                'price' => $this->getByTitlenAuthor($book['title'], $book['author'])->price,
                'amount' => $this->getByTitlenAuthor($book['title'], $book['author'])->amount,
                'author' => $this->getByTitlenAuthor($book['title'], $book['author'])->author
            ]));
        else {
            $this->add($book);
        }
    }
}
