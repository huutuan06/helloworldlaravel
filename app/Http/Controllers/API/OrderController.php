<?php

namespace App\Http\Controllers\API;

use App\Model\Book;
use App\Model\Category;
use App\Model\Order;
use App\Model\Book_Order;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    protected $modelCategory;
    protected $modelBook;
    protected $modelOrder;
    protected $modelBookOrder;
    protected $modelUser;

    public function __construct(Category $category, Book $book, Order $order, Book_Order $book_Order, User $user)
    {
        $this->modelBook = $book;
        $this->modelCategory = $category;
        $this->modelOrder = $order;
        $this->modelBookOrder = $book_Order;
        $this->modelUser = $user;
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
                'code' => 0,
                'message' => "Success"
            ],
            'data' => [
                'categories' => $categories,
                'books' => $books
            ]
        ]);
        return json_encode($this->response_array);
    }

    public function submit(Request $request)
    {
        \Log::info($request);
        $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

        $this->modelOrder->add(array([
            'code' => $code,
            'user_id' => $request->user_id,
            'address' => $request->address['address']
        ]));
        \Log::info($code);
        \Log::info($this->modelOrder->getOrderByCode($code)->id);
        foreach ($request->carts as $cart) {
            $this->modelBookOrder->add(array([
                "book_id" => $cart['book_id'],
                "book_title" => $cart['book_title'],
                "order_id" => $this->modelOrder->getOrderByCode($code)->id,
                "total_book" => $cart['total_book'],
                "price" => $cart['price'],
                "image" => $cart['image']
            ]));
        }
        $this->modelUser->updatePhoneNumber($request->user_id, $request->address['phone_number']);
        $this->response_array = ([
            'http_response_code' => http_response_code(),
            'error' => [
                'code' => 0,
                'message' => "Success"
            ],
            'data' => null
        ]);
        return json_encode($this->response_array);
    }


}
