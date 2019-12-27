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
        $credentials = $request->address->only('address','name','phone_number');
        $rules = [
            'address' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            if ($validator->errors()->get('name') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'      => 201,
                        'message'   => "Please provide a properly name"
                    ],
                    'data' => null
                ]);
            } else if ($validator->errors()->get('address') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code' => 201,
                        'message' => "Please provide a properly address"
                    ],
                    'data' => null
                ]);
            } else if ($validator->errors()->get('phone_number') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code' => 201,
                        'message' => "Please provide a properly phone number"
                    ],
                    'data' => null
                ]);
            } else {
                $this->modelOrder->add(array([
                    'code' => mt_srand(10),
                    'user_id' => $request->user_id,
                    'address' => $request->address->address
                ]));
                foreach ($request->carts as $cart) {
                    $this->modelBookOrder->add(array([
                        "book_id" => $cart->book_id,
                        "book_title" => $cart->book_title,
                        "order_id"=> $this->modelOrder->getLastOrder()->id,
                        "total_book" => $cart->total_book,
                        "price" => $cart->price,
                        "image" => $cart->image
                    ]));
                }
                $this->modelUser->updatePhoneNumber($request->user_id, $request->address->phone_number);
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 0,
                        'message'   => "Success"
                    ],
                    'data' => null
                ]);
                return json_encode($this->response_array);
            }
        }
    }
}
