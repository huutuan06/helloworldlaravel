<?php

namespace App\Http\Controllers\API;

use App\Model\Book;
use App\Model\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $modelCategory;
    protected $modelBook;

    public function __construct(Category $category, Book $book)
    {
        $this->modelBook = $book;
        $this->modelCategory = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = $this->modelCategory->get();
        $books = $this->modelBook->get();
        $this->response_array = ([
            'http_response_code' => http_response_code(),
            'error' => [
                'code'        => 0,
                'message'   => "Success"
            ],
            'data' => [
                'categories' => $categories,
                'books' => $books
            ]
        ]);
        return json_encode($this->response_array);
    }

    public function submit(Request $request) {

    }
}
