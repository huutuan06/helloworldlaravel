<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\Category;
use Illuminate\Http\Request;

class NavigationController extends Controller
{

    protected $mModelCat;
    protected $mModelBook;

    public function __construct(Category $category, Book $book) {
        $this->mModelCat = $category;
        $this->mModelBook = $book;
    }

    /**
     * Ajax, using those methods to navigate to Page in DashBoard screen
     */
    public function dashboard() {
        $returnHTML = view('ajax.page.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function book() {
        $returnHTML = view('ajax.page.book.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function category() {
        $returnHTML = view('ajax.page.category.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function user() {
        $returnHTML = view('ajax.page.user.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function customer() {
        $returnHTML = view('ajax.page.user.customer')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function cms($id) {
        $categories = $this->mModelCat->get();
//        $user = DB::table('users')->where('id', Auth::user()->id)->first();
//        self::deleteTempImageResource(0);
//        self::deleteTempMediaResource(0);
        $book = $this->mModelBook->getById($id);
        try {
            $returnHTML = view('ajax.page.cms.index')
                ->with(compact('book'))
                ->with('book', $book)
                ->render();
            $response_array = ([
                'success' => true,
                'html'      => $returnHTML
            ]);
            echo json_encode($response_array);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
    }
    public function books(Request $id) {
        $returnHTML = view('ajax.page.category.books')->render();
        $response_array = ([
            'success' => true,
            'id' => $id,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function orders() {
        $returnHTML = view('ajax.page.order.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }
    public function order() {
        $returnHTML = view('ajax.page.order.detail')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

}
