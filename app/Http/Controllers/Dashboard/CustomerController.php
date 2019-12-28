<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use App\Utilize\Helper;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadTrait;
use Storage;
use Config;

/**
 * Class CustomerController
 * @package App\Http\Controllers\Dashboard
 */
class CustomerController extends Controller
{
    protected $mModelCustomer;
    protected $helper;
    use HasTimestamps;
    use UploadTrait;


    public function __construct(User $user, Helper $helper)
    {
        $this->mModelUser = $user;
        $this->helper = $helper;
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
        $i = 1;
        foreach ($users as $user) {
            $arr = array(
                'id' => $i,
                'name' => $user->name,
                'email' => $user->email,
                'date_of_birth' => $user->date_of_birth == null ? null : date("M d, Y", $user->date_of_birth),
                'avatar' => $user->avatar,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'gender' => $user->gender,
                'manipulation' => $user->id
            );
            $i++;
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
        \Log::info($request);
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
        $request->avatar = '';
        if (isset($_FILES['avatar']['tmp_name'])) {
            if (!file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                $request->avatar = 'https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/avatar/data/profile.png';
            } else {
                $fileExt = $request->file('avatar')->getClientOriginalName();
                $fileName = pathinfo($fileExt, PATHINFO_FILENAME);
                $info = pathinfo($_FILES['avatar']['name']);
                if (preg_match("/^.*picture.*$/", $info['filename']) == 0) {
                    $ext = $info['extension'];
                } else {
                    $ext = 'png';
                }
                $key = $this->helper->clean(trim(strtolower($fileName)) . "_" . time()) . "." . $ext;
                Storage::disk('s3')->put(Config::get('constants.options.ezbook') . '/' . $key, fopen($request->file('avatar'), 'r+'), 'public');
                $request->avatar = preg_replace("/^http:/i", "https:", Storage::disk('s3')->url(Config::get('constants.options.ezbook') . '/' . $key));
            }
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
                        'date_of_birth' => strtotime($request->date_of_birth),
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
                    'description' => "The customer didn't exist in our system!"
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
        \Log::info($request);
        $credentials = $request->only('_name','_phone_number','_address','_date_of_birth','_avatar', 'gender');
        $rules = [
            '_name' => 'required',
            '_phone_number' => 'required',
            '_address' => 'required',
            '_date_of_birth' => 'required',
            '_avatar' => 'required',
            '_gender' => 'required'
        ];
        $customMessages = [
            'required' => 'Please :field fill in form'
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
                        'description' => "Update the customer success!"
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
                                'description' => "Update the customer success!"
                            ],
                            'user' => $this->mModelUser->getById($id)
                        ]));
                    } else {
                        return json_encode(([
                            'message' => [
                                'status' => "error",
                                'description' => "Update the customer failure!"
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
                    'description' => 'Delete the customer failure!'
                ]
            ]);
        } else {
            if ($filename != 'https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/avatar/data/profile.png'){
                Storage::disk('s3')->delete(basename($filename));
            }
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => 'Delete the customer successfully!'
                ],
                'name' => $user->name
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
