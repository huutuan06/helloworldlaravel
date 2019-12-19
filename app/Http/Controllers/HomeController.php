<?php

namespace App\Http\Controllers;

use App\Model\Book;
use App\Model\Metas;

class HomeController extends Controller
{
    protected $mModelBook;
    protected $mModelMeta;

    public function __construct(Book $book, Metas $metas) {
        $this->mModelBook = $book;
        $this->mModelMeta = $metas;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function pages($slug)  {
        \Log::info($slug);
        $books = $this->mModelBook->get();
        $id = 0;
        foreach ($books as $book) {
            $temp = preg_replace('/s+/', '-', $book->title);
            if (strcmp($temp, $slug) == 0) {
                $id = $book->id;
                break;
            }
        }
        $obj = $this->mModelMeta->getItemByBookID($id);
        try {
            return view('welcome')
                ->with('book', $this->mModelBook->getById($id))
                ->with(compact('obj'))
                ->render();
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return null;
    }
}
