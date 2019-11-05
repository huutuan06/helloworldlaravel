<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadTrait;


class UserController extends Controller
{
    protected $mModelUser;
    use HasTimestamps;
    use UploadTrait;
    public function __construct(User $user)
    {
        $this->mModelUser = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->mModelUser->get();
        $collections = collect();
        foreach ($users as $user) {
            $arr = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'date_of_birth' => date("d M Y", strtotime( $user->date_of_birth)),
                'avatar' => $user->avatar,
                'address' => $user->address,
                'gender' => $user->gender,
                'manipulation' => $user->id
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
        $credentials = $request->only('name', 'email', 'password', 'avatar', 'date_of_birth', 'gender', 'address');
        if ($request->has('avatar')) {
            $image = $request->file('avatar');
            $name = str_slug($request->input('name')).'_'.time();
            $folder = '/images/users/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $this->uploadImage($image, $folder, 'public', $name);
            $request->avatar = $filePath;
        } else {
            $request->avatar = '/images/favicon.ico';
        }
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ];
        $customMessages = [
            'required' => 'The attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $this->response_array = ([
                'message' => [
                    'status' => 'invalid',
                    'description' => $validator->errors()->first()
                ]
            ]);
        } else {
            if ($this->mModelUser->getByEmail($request->email)) {
                $this->response_array = ([
                    'message' => [
                        'status' => 'invalid',
                        'description' => 'The email already exists in the system'
                    ]
                ]);
            } else {
                if ($this->mModelUser->add(array([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => $request->password,
                        'date_of_birth' => $request->date_of_birth,
                        'gender' => $request->gender,
                        'avatar' => $request->avatar,
                        'address' => $request->address,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp(),
                    ])) > 0) {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'success',
                            'description' => 'Add a new user successfully'
                        ],
                        'user' => $this->mModelUser->getByEmail($request->email)
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
        $user = $this->mModelUser->getById($id);
        if ($user == null) {
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
                'customer' => $user
            ]));
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
