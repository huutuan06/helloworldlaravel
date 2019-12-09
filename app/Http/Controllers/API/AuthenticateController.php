<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{

    protected $response_array;
    protected $mModelUser;

    use HasTimestamps;

    public function __construct(User $user)
    {
        $this->mModelUser = $user;
    }

    /**
     * Login with Google/Facebook from Android App
     * @param Request $request
     */

    public function login(Request $request) {
        $credentials = $request->only('name','email');
        $rules = [
            'name' => 'required',
            'email' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            if ($validator->errors()->get('name') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 201,
                        'message'   => "Please provide a properly name"
                    ],
                    'data' => null
                ]);
            } else if ($validator->errors()->get('email') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 201,
                        'message'   => "Please provide a properly formatted email address"
                    ],
                    'data' => null
                ]);
            } else if ($validator->errors()->get('password') != null) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 201,
                        'message'   => "Please provide a properly formatted password"
                    ],
                    'data' => null
                ]);
            }
        } else {
            if ($this->mModelUser->getByEmail($request->email) != null) {
                $user = $this->mModelUser->getByEmail($request->email);
                $this->mModelUser->deleteById($user->id);
                $request['password'] =  str_random(8);
                $jwt_credentials = $request->only('email','password');
                if ($this->mModelUser->add(array([
                        'id' => $user->id,
                        'name' => $request->name != null ? $request->name : $user->name,
                        'email' => $user->email,
                        'password' => Hash::make($request->password),
                        'phone_number' => $user->phone_number,
                        'date_of_birth' => $user->date_of_birth,
                        'gender' => $user->gender,
                        'avatar' => $request->image != null ? $request->image : $user->avatar,
                        'address' => $user->address,
                        'is_verified' => $user->is_verified,
                        'platform' => $request->platform != null ? $request->platform : $user->platform,
                        'remember_token' => $user->remember_token,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at
                    ])) > 0) {
                    // Success
                    $this->response_array = ([
                        'http_response_code' => http_response_code(),
                        'error' => [
                            'code'        => 0,
                            'message'   => "Success"
                        ],
                        'data' => [
                            'user' => $this->mModelUser->getByEmail($request->email),
                            'token' => 'Bearer ' . JWTAuth::attempt($jwt_credentials),
                        ]
                    ]);
                }
            } else {
                // Update to DB. Please search Model in Laravel
                $request['password'] =  str_random(8);
                $jwt_credentials = $request->only('email','password');
                if ($this->mModelUser->add(array([
                        'id' => self::resetOrderInDB(),
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'is_verified' => 0,
                        'avatar' => $request->image,
                        'platform' => $request->platform,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    // Success
                    $this->response_array = ([
                        'http_response_code' => http_response_code(),
                        'error' => [
                            'code'        => 0,
                            'message'   => "Success"
                        ],
                        'data' => [
                            'user' => $this->mModelUser->getByEmail($request->email),
                            'token' => 'Bearer ' . JWTAuth::attempt($jwt_credentials),
                        ]
                    ]);
                } else {
                    // We get error when try to add new record to table users
                    $this->response_array = ([
                        'http_response_code' => http_response_code(),
                        'error' => [
                            'code'        => 202,
                            'message'   => "The email address you have entered is already registered"
                        ],
                        'data' => null
                    ]);
                }
            }
        }
        echo json_encode($this->response_array);
    }

    public function profile($request) {
        \Log::info($request);
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

