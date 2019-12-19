<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\Category;
use App\Model\Metas;
use Illuminate\Http\Request;

class NavigationController extends Controller
{

    protected $mModelCat;
    protected $mModelBook;
    protected $mModelMeta;

    public function __construct(Category $category, Book $book, Metas $metas) {
        $this->mModelCat = $category;
        $this->mModelBook = $book;
        $this->mModelMeta = $metas;
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
        $book = $this->mModelBook->getById($id);
        try {
            $returnHTML = view('ajax.page.cms.index')
                ->with(compact('book'))
                ->with('book', $book)
                ->with('description', $this->mModelMeta->getItemByBookID($book->id) != null ? $this->mModelMeta->getItemByBookID($book->id)->description : null )
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
