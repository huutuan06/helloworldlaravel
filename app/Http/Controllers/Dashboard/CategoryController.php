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

    public function __construct(Category $cat)
    {
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
                'description' => $category->description,
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
        $credentials = $request->only('name', 'description');
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form'
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
            if ($this->mModelCat->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The category already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelCat->add(array([
                        'name' => $request->name,
                        'description' => $request->description,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    // Success
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new category successfully!"
                        ],
                        'category' => $this->mModelCat->getByName($request->name)
                    ]));
                } else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new category failure!"
                        ]
                    ]));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat = $this->mModelCat->getById($id);
        if ($cat == null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "The customer didn't exist in our system!"
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => ""
                ],
                'category' => $cat
            ]));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $credentials = $request->only('name', 'description');
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form'
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
            if ($this->mModelCat->getById($request->id)->name == $request->name) {
                $this->mModelCat->updateById($id, $request);
                return json_encode(([
                    'message' => [
                        'status' => "success",
                        'description' => "Update the category success!"
                    ],
                    'category' => $this->mModelCat->getById($id)
                ]));
            } else {
                if ($this->mModelCat->getByName($request->name)) {
                    return json_encode(([
                        'message' => [
                            'status' => "invalid",
                            'description' => "The category already exists in the system!"
                        ]
                    ]));
                } else {
                    if ($this->mModelCat->updateById($id, $request) > 0) {
                        return json_encode(([
                            'message' => [
                                'status' => "success",
                                'description' => "Update the category success!"
                            ],
                            'category' => $this->mModelCat->getById($id)
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = $this->mModelCat->deleteById($id);
        if ($this->mModelCat->getById($id) != null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the category failure!",
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Delete the category success! "
                ],
                'id' => $id
            ]));
        }
    }
}
