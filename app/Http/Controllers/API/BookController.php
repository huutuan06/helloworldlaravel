<?php

namespace App\Http\Controllers\API;

use App\Model\Category;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    protected $modelCategory;

    public function __construct(Category $category )
    {
        $this->modelCategory = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        /**
         * For example:
         * I just dummy two array and nested two array to show data.
         * After you have Database and you can query from DB and execute response that data you want.
         *
         */
        $categpries = $this->modelCategory->getAll();

        $result = array();
        foreach($categpries as $item) {
            $result[] = array(
                'id' => $item->id,
                'name' => $item->name
            );
        }

        $this->response_array = ([
            'http_response_code' => http_response_code(),
            'error' => [
                'code'        => 0,
                'message'   => "Success"
            ],
            'data' => [
                'books' => $result
            ]
        ]);
        return json_encode($this->response_array);
    }
}
