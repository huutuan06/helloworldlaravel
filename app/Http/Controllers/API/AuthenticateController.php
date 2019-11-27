<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        $jwt_credentials = $request->only('email','password');

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
                $request['password'] = $this->mModelUser->getByEmail($request->email)->password;

                $jwt_credentials = $request->only('email','password');
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 0,
                        'message'   => "Success"
                    ],
                    'data' => [
                        'user' => $this->mModelUser->getByEmail($request->email),
//                        'token' => 'Bearer ' . JWTAuth::attempt($jwt_credentials),
                        'token' => 'Bearer ' . JWTAuth::fromUser($this->mModelUser->getByEmail($request->email)),
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
                            'token' => 'Bearer ' . JWTAuth::fromUser($this->mModelUser->getByEmail($request->email)),
//                            'token' => 'Bearer ' . JWTAuth::attempt($jwt_credentials),
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

    public function register(Request $request) {

        // Token will be generated by two field email, password, if you want to custom it and add more.
        $jwt_credentials = $request->only('email', 'password');

        // This is how Laravel Framework handle case error (email should be required from form, end-user)
        $credentials = $request->only('name','email','password');
        $rules = [
            'name' => 'required', // Name, email and password should be required. Let's run it in Postman to see clearly.
            'email' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);

        // Class 1: Try catch with field is required or lengh or using regex, show error below

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
            // Class 2: Check existed or not existed in DB to show warning
            if ($this->mModelUser->isEmailExisted($request->email)) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 202,
                        'message'   => "The email address you have entered is already registered"
                    ],
                    'data' => null
                ]);
            } else {
                // Update to DB. Please search Model in Laravel
                if ($this->mModelUser->add(array([
//                    'id' => 0,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password), // We can update more field if you want.
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
                            'user' => $this->mModelUser->getByEmail($request->email), // Get user and return it to mobile
                            'token' => 'Bearer ' . JWTAuth::attempt($jwt_credentials), // Generate Token.
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

    /**
     * Get Request from Mobile with Email/Password and allow user to log in our system
     * @param Request $request
     */
    public function login(Request $request) {
        $jwt_credentials = $request->only('email', 'password');
        $credentials = $request->only('email','password');
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);

        // Class 1: Try catch with field is required or lengh or using regex, show error below
        if ($validator->fails()) {
            if ($validator->errors()->get('email') != null) {
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
            // Class 2: Check existed or not existed in DB to show warning
            if (!$this->mModelUser->isEmailExisted($request->email)) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 203,
                        'message'   => "You aren't in our system. Please register!"
                    ],
                    'data' => null
                ]);
            }
            else if(0 == $this->mModelUser->getByEmail($request->email)->is_verified) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 204,
                        'message'   => "Your account is not activated yet!"
                    ],
                    'data' => null
                ]);
            } else {
                if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    $this->response_array = ([
                        'error' => [
                            'code' => 0,
                            'message' => "Success"
                        ],
                        'data' => [
                            'user' => $this->mModelUser->getByEmail($request->email),
                            'token' => 'Bearer '.JWTAuth::attempt($jwt_credentials)
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
}

