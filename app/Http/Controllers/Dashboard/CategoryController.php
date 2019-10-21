<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Category;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected $mModelCat;
    use HasTimestamps;

    public function __construct(Category $cat) {
        $this->middleware('auth');
        $this->mModelCat = $cat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->mModelCat->get();
        $collections = collect();
        foreach ($categories as $category) {
            $arr = array(
                'id' => $category->id,
                'name' => $category->name,
                'manipulation' => $category->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    // View Category/Edit Category
    public function create()
    {
        //
    }

    // Save Category
    public function store(Request $request)
    {
        $credentials = $request->only('name');
        $rules = [
            'name' => 'required'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $this->response_array = ([
                'message'       => [
                    'status'        => "invalid",
                    'description'   => $validator->errors()->first()
                ]
            ]);
        } else {
            if ($this->mModelCat->getByName($request->name) > 0) {
                $this->response_array = ([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The category already exists in the system!"
                    ]
                ]);
            } else {
                if ($this->mModelCat->add(array([
                        'id' => 0,
                        'name' => $request->name,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    // Success
                    $this->response_array = ([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new category successfully"
                        ],
                        'category' => $this->mModelCat->getByName($request->name)
                    ]);
                } else {
                    $this->response_array = ([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new category failure"
                        ]
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
