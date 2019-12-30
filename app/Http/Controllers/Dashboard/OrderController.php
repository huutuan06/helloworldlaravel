<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class OrderController extends Controller
{
    protected $mOrderBook;
    use HasTimestamps;

    public function __construct(Order $order)
    {
        $this->middleware('auth');
        $this->mOrderBook = $order;
    }

    public function index()
    {
        $orders = $this->mOrderBook->getOrders();
        $collections = collect();
        foreach ($orders as $order) {
            $arr = array(
                'id' => $order->id,
                'code' => $order->code,
                'email' => $this->mOrderBook->getUserByOrder($order->user_id)->email,
                'address' => $order->address,
                'confirmed_ordering' =>  $order->confirmed_ordering,
                'delivery' => $order->delivery,
                'success' => $order->success,
                'cancel' => $order->cancel,
                'updated_at' => $order->updated_at,
                'manipulation' => $order->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    public function show($id)
    {
        $order = $this->mOrderBook->getOrderById($id);
        if ($order == null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "The order didn't exist in our system!"
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => ""
                ],
                'order' => $order
            ]));
        }
    }


    public function getOrderDetail(Request $request)
    {
        $order = $this->mOrderBook->getById($request->id);
        if ($order!=null) {
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => 'Get detail order success!'
                ],
                'data' => [
                    'order_id' => $order->id,
                    'customer_name' => $order->user_id,
                    'email' => 'Email',
                    'books' => 'Book',
                    'amount' => 10,
                    'date' => $order->date,
                    'address' => 'Address',
                    'order_status' => $order->status,
                    'manipulation' => $order->id,
                ]
            ]);
        }
        else return json_encode([
           'message' => [
               'status' => 'error',
               'description' => 'Get detail order failure!'
           ]
        ]);
    }

    public function store(Request $request) {
        $confirmed_ordering = $cancel = $success = $delivery = 0;
        if ($request->order_status == "confirm") {
            $confirmed_ordering = 1;
            $cancel = $success = $delivery = 0;
        } else if ($request->order_status == "delivery") {
            $cancel = $success = $confirmed_ordering = 0;
            $delivery = 1;
        } else if ($request->order_status == "success") {
            $cancel = $delivery = $confirmed_ordering = 0;
            $success = 1;
        } else if ($request->order_status == "reject") {
            $success = $delivery = $confirmed_ordering = 0;
            $cancel = 1;
        }
        if ($this->mOrderBook->getOrderByCode($request->order_code) != null) {
            $item = $this->mOrderBook->getOrderByCode($request->order_code);
            $this->mOrderBook->updateById($item->id, array([
                'id' => $item->id,
                'code' => $item->code,
                'user_id' => $item->user_id,
                'address' => $item->address,
                'payment' => $item->payment,
                'confirmed_ordering' => $confirmed_ordering,
                'unsuccessful_payment' => $item->unsuccessful_payment,
                'delivery' => $delivery,
                'success' => $success,
                'cancel' => $cancel,
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            ]));

            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Update the order as successfully"
                ],
                'order' => $this->mOrderBook->getOrderByCode($request->order_code)
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Update the order as failure"
                ]
            ]));
        }
    }
}
