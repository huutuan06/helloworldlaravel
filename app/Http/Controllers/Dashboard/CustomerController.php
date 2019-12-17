<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadTrait;


/**
 * Class CustomerController
 * @package App\Http\Controllers\Dashboard
 */
class CustomerController extends Controller
{
    protected $mModelCustomer;
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
        $users = $this->mModelUser->getAllCustomers();
        $collections = collect();
        foreach ($users as $user) {
            $arr = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'date_of_birth' => $user->date_of_birth == null ? null : date("M d, Y", $user->date_of_birth),
                'avatar' => $user->avatar,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'gender' => $user->gender,
                'manipulation' => $user->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');
        $rules = [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required','string', 'email', 'max:255', 'unique:users',
            'password' => 'required'
        ];
        $customMessages = [
            'required' => 'The attribute field is required',
            'email' => 'The email address is invalid',
            'max:255' => 'The max of the length of content is limited by 255 characters.',
            'unique:users' => 'The email address have already existed in the system',
        ];
        if ($request->has('avatar')) {
            $image = $request->file('avatar');
            $name = str_slug($request->input('name')).'_'.time();
            $folder = '/images/users/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $this->uploadImage($image, $folder, 'public', $name);
            $request->avatar = $filePath;
        } else {
            $request->avatar = Request::url().'/images/users/'.'profile.png';
        }
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
                        'description' => 'The email already exists in the system!'
                    ]
                ]);
            } else {
                if ($this->mModelUser->add(array([
                        'id' => self::resetOrderInDB(),
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'date_of_birth' => $request->date_of_birth,
                        'gender' => $request->gender,
                        'phone_number' => $request->phone_number,
                        'avatar' => $request->avatar,
                        'address' => $request->address,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp(),
                    ])) > 0) {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'success',
                            'description' => 'Create a new customer successfully'
                        ],
                        'user' => $this->mModelUser->getByEmail($request->email)
                    ]);
                } else {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'error',
                            'description' => 'Create a new customer in failure'
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
        $user = $this->mModelUser->getById($id);
        if ($user == null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "The user didn't exist in our system!"
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => ""
                ],
                'user' => $user
            ]));
        }
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->only('name', 'email','password','phone_number','address','date_of_birth','avatar', 'gender');
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form'
        ];
        $request->password = bcrypt($request->password);
        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            return json_encode(([
                'message' => [
                    'status' => "invalid",
                    'description' => $validator->errors()->first()
                ]
            ]));
        } else {
            if ($this->mModelUser->getById($request->id)->email == $request->email) {
                if ($request->avatar === null) {
                    $request->avatar = $this->mModelUser->getById($request->id)->avatar;
                } else {
                    $this->deleteImage('public', $this->mModelUser->getById($request->id)->avatar);
                    $avatar = $request->file('avatar');
                    $name = str_slug($request->input('name')) . '_' . time();
                    $folder = '/images/users/';
                    $filePath = $folder . $name . '.' . $avatar->getClientOriginalExtension();
                    $this->uploadImage($avatar, $folder, 'public', $name);
                    $request->avatar = $filePath;
                }
                $this->mModelUser->updateById($id, $request);
                return json_encode(([
                    'message' => [
                        'status' => "success",
                        'description' => "Update the user success!"
                    ],
                    'user' => $this->mModelUser->getById($id)
                ]));
            } else {
                if ($this->mModelUser->getByEmail($request->email)) {
                    return json_encode(([
                        'message' => [
                            'status' => "invalid",
                            'description' => "The email already exists in the system!"
                        ]
                    ]));
                } else {
                    $oldAvatar = $this->mModelUser->getById($request->id)->avatar;
                    if ($request->avatar === null) {
                        $request->avatar = $this->mModelUser->getById($request->id)->avatar;
                    } else {
                        $avatar = $request->file('avatar');
                        $name = str_slug($request->input('name')) . '_' . time();
                        $folder = '/images/users/';
                        $filePath = $folder . $name . '.' . $avatar->getClientOriginalExtension();
                        $this->uploadImage($avatar, $folder, 'public', $name);
                        $request->avatar = $filePath;
                    }
                    if ($this->mModelUser->updateById($id, $request) > 0) {
                        if ($request->avatar != null) {
                            $this->deleteImage('public', $oldAvatar);
                        }
                        return json_encode(([
                            'message' => [
                                'status' => "success",
                                'description' => "Update the user success!"
                            ],
                            'user' => $this->mModelUser->getById($id)
                        ]));
                    } else {
                        return json_encode(([
                            'message' => [
                                'status' => "error",
                                'description' => "Update the user failure!"
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
        $user = $this->mModelUser->getById($id);
        $filename = $user->avatar;
        $this->mModelUser->deleteById($id);
        if ($this->mModelUser->getById($id) != null) {
            return json_encode([
                'message' => [
                    'status' => 'error',
                    'description' => 'Delete the user failure!'
                ]
            ]);
        } else {
            if ($filename != '/images/users/profile.png'){
                $this->deleteImage('public', $filename);
            }
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => 'Delete the user successfully!'
                ],
                'id' => $id
            ]);
        }
    }

    /**
     * Order ID in User table
     * @return int
     */
    public function resetOrderInDB() {
        $i = 1;
        while (true){
            if ($this->mModelUser->getById($i) == null) break;
            $i++;
        }
        return $i;
    }
}
