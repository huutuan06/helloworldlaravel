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
     * Allow user to register from Mobile
     * @param Request $request
     */

    public function loginSocialNetwork(Request $request) {
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
            if ($this->mModelUser->isEmailExisted($request->email)) {
                $request['password'] = $this->mModelUser->isEmailExisted($request->email)['password'];
                $jwt_credentials = $request->only('email','password');
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
                // Update to DB. Please search Model in Laravel
                $request['password'] =  str_random(25);
                $jwt_credentials = $request->only('email','password');
                if ($this->mModelUser->add(array([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'is_verified' => 0,
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

    public function getPharmacy() {
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

