<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Book_Order;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Yajra\DataTables\Facades\DataTables;


class BookOrderController extends Controller
{
    protected $mOrderBook;
    use HasTimestamps;
    use UploadTrait;

    public function __construct(Book_Order $book_Order)
    {
        $this->middleware('auth');
        $this->mOrderBook = $book_Order;
    }

    public function show($id)
    {
        $orders = $this->mOrderBook->get($id);
        $collections = collect();
        foreach ($orders as $order) {
            $arr = array(
                'id' => $order->id,
                'book_id' => $order->book_id,
                'book_title' => $order->book_title,
                'order_id' => $order->order_id,
                'total_book' =>  $order->total_book,
                'price' => $order->price,
                'image' => $order->image
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }
}
