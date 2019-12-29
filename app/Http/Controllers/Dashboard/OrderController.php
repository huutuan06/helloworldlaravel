<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Order;
use App\Traits\UploadTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
Use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;


class OrderController extends Controller
{
    protected $mOrderBook;
    use HasTimestamps;
    use UploadTrait;

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
                'updated_at' => Carbon::parse($order->updated_at),
                'manipulation' => $order->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    public function store(Request $request)
    {

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

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

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
}
