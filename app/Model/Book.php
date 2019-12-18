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

    public function getByNumeral($numeral)
    {
        return DB::table('books')->where('numeral', $numeral)->first();
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
        if (sizeof($this->get()) > 0) {
            if ($this->getByNumeral($book['numeral']) != null) {
                $item = $this->getByNumeral($book['numeral']);
                // Old => Update
                \Log::info(abs(($book['price'] - $item->price) < 0.0001));
                if (strcmp($book['title'],$item->title) == 0 && abs(($book['price'] - $item->price) < 0.0001) == 1 && strcmp($book['author'], $item->author) == 0) {
                    $this->updateById($item->id, array([
                        'id' => $item->id,
                        'title' => $item->title,
                        'numeral' => $book['numeral'],
                        'image' => $item->image,
                        'category_id' => $item->category_id,
                        'description' => $item->description,
                        'total_pages' => $item->total_pages,
                        'price' => $item->price,
                        'amount' => $item->amount,
                        'author' => $item->author
                    ]));
                } else {
                    $this->updateById($item->id, array([
                        'id' => $item->id,
                        'title' => $item->title,
                        'numeral' => 0,
                        'image' => $item->image,
                        'category_id' => $item->category_id,
                        'description' => $item->description,
                        'total_pages' => $item->total_pages,
                        'price' => $item->price,
                        'amount' => $item->amount,
                        'author' => $item->author
                    ]));
                    // New => Add
                    $this->add(array(
                        'id' => $book['id'],
                        'title' => $book['title'],
                        'numeral' => $book['numeral'],
                        'image' => $book['image'],
                        'category_id' => $book['category_id'],
                        'description' => $book['description'],
                        'total_pages' => $book['total_pages'],
                        'price' => $book['price'],
                        'amount' => $book['amount'],
                        'author' => $book['author']
                    ));
                }
            } else {
                $this->add($book);
            }
        } else {
            $this->add($book);
        }
    }
}
