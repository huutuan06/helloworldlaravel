<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
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

    public function add($data)
    {
        return DB::table('categories')->insert($data);
    }

    public function get()
    {
        return DB::table('categories')->get();
    }

    public function getByName($name)
    {
        return DB::table('categories')->where('name', $name)->first();
    }

    public function getById($id)
    {
        return DB::table('categories')->where('id', $id)->first();
    }

    public function deleteById($id)
    {
        return DB::table('categories')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('categories')->where('id', $id)->update(['name' => $data['name'], 'description' => $data['description']]);
    }

    public function books()
    {
        return $this->belongsToMany('App\Model\Book');
    }
//
//    public function getBooks($id)
//    {
//        $bookIds = DB::table('book_category')->select('book_id')->where('category_id', $id)->get();
//        $collections = collect();
//        foreach ($bookIds as $bookId) {
//            $book = DB::table('books')->where('id', $bookId->book_id)->first();
//            $arr = array(
//                'id' => $book->id,
//                'title' => $book->title,
//                'image' => $book->image,
//                'description' => $book->description,
//                'total_pages' => $book->total_pages,
//                'price' => $book->price,
//                'amount' => $book->amount,
//                'manipulation' => $book->id
//            );
//            $collections->push($arr);
//
//        }
//        return $collections;
//    }
//
//    public function addBookToCategory($category_id, $book_id)
//    {
//        $category = Category::find($category_id);
//        $category->books()->attach($book_id);
//    }
//
//    public function detachBook($category_id, $book_id)
//    {
//        $category = Category::find($category_id);
//        return $category->books()->detach($book_id);
//
//    }
}
