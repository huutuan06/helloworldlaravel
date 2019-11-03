<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;


class BookController extends Controller
{
    protected $mModelBook;
    use HasTimestamps;

    public function __construct(Book $book) {
        $this->middleware('auth');
        $this->mModelBook = $book;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = $this->mModelBook->get();
        $collections = collect();
        foreach ($books as $book) {
            $arr = array(
                'id'=>$book->id,
                'title'=>$book->title,
                'image'=>$book->image,
                'description'=>$book->description,
                'total_pages'=>$book->total_pages,
                'price'=>$book->price,
                'manipulation' => $book->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('title','image','description','total_pages','price');
        $rules = [
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required',
        ];
        $customMessages = [
            'required' => 'The attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $this->response_array =([
                'message' => [
                    'status' => 'invalid',
                    'description' => $validator->errors()->first()
                ]
            ]);
        } else {
            if ($this->mModelBook->getByTitle($request->title)) {
                $this->response_array = ([
                    'message' => [
                        'status' => 'invalid',
                        'description' => 'The book already exists in the system'
                    ]
                ]);
            } else {
                if ($this->mModelBook->add(array([
                    'title' => $request->title,
                    'image' => $request->image,
                    'description' => $request->description,
                    'total_pages' => $request->total_pages,
                    'price' => $request->price,
                    'created_at' => $this->freshTimestamp(),
                    'updated_at' => $this->freshTimestamp(),
                ])) >0) {
                    $this->response_array = ([
                        'message' => [
                            'status' =>'success',
                            'description' => 'Add a new book successfully'
                        ],
                        'book' => $this->mModelBook->getByTitle($request->title)
                    ]);
                }
            }
        }
        echo json_encode($this->response_array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->mModelBook->getById($id);
        if ($book == null) {
            return json_encode([
                'message'=> [
                    'status' => 'error',
                    'description' => "The book doesn't exist in the system!"
                ]
            ]);
        } else {
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => ''
                ],
                'book' => $book
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $credentials = $request->only('title','image','description','total_pages','price');
        $rules = [
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form!'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            return json_encode(([
                'message' => [
                    'status' => "invalid",
                    'description' => $validator->errors()->first()
                ]
            ]));
        } else {
            if ($this->mModelBook->getById($request->id)->title == $request->title) {
                $this->mModelBook->updateById($id, $request);
                return json_encode(([
                    'message' => [
                        'status' => "success",
                        'description' => "Update the category success!"
                    ],
                    'book' => $this->mModelBook->getById($id)
                ]));
            } else {
                if ($this->mModelBook->getByTitle($request->title)) {
                    return json_encode(([
                        'message' => [
                            'status' => "invalid",
                            'description' => "The category already exists in the system!"
                        ]
                    ]));
                } else {
                    if ($this->mModelBook->updateById($id, $request) > 0) {
                        return json_encode(([
                            'message' => [
                                'status' => "success",
                                'description' => "Update the category success!"
                            ],
                            'book' => $this->mModelBook->getById($id)
                        ]));
                    } else {
                        return json_encode(([
                            'message' => [
                                'status' => "error",
                                'description' => "Update the category failure!"
                            ]
                        ]));
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->mModelBook->deleteById($id);
        if ($this->mModelBook->getById($id) != null) {
            return json_encode([
               'message' => [
                   'status' => 'error',
                   'description' => 'Delete the book failure!'
               ]
            ]);
        } else {
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => 'Delete the book successfully!'
                ],
                'id' => $id
            ]);
        }
    }
}
