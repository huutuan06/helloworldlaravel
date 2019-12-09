<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class ProfileController extends Controller
{

    protected $response_array;
    protected $mModelUser;

    use HasTimestamps;
    use UploadTrait;

    public function __construct(User $user)
    {
        $this->mModelUser = $user;
    }

    public function profile($request) {
        \Log::info($request);
//        $image_path = '';
//        if ($request->has('avatar')) {
//            $image = $request->file('avatar');
//            $name = str_slug($request->input('name')).'_'.time();
//            $folder = '/images/users/';
//            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
//            $this->uploadImage($image, $folder, 'public', $name);
//            $request->avatar = $filePath;
//        } else {
//            $request->avatar = Request::url().'/images/users/'.'profile.png';
//        }
//        if ($this->modelUser->getByEmail($request->mUserMail)) {
//            if ($this->modelUser->updateItem($this->getInfoMUser($request, $image_path, true)) > 0) {
//                $response_array = ([
//                    'error' => [
//                        'code' => 0,
//                        'message' => "Cập nhật thông tin người chơi thành công!"
//                    ],
//                    'data' => [
//                        'user' => DB::table('users')->where('email', '=', $request->mUserMail)->first(),
//                    ]
//                ]);
//                echo json_encode($response_array);
//            } else {
//                $response_array = ([
//                    'error' => [
//                        'code' => 408,
//                        'message' => "Cập nhật thông tin người chơi thất bại!"
//                    ],
//                    'data' => null
//                ]);
//                echo json_encode($response_array);
//            }
//        } else {
//            $response_array = ([
//                'error' => [
//                    'code' => 223,
//                    'message' => "Người chơi không tồn tại trong hệ thống!"
//                ],
//                'data' => null
//            ]);
//            echo json_encode($response_array);
//        }
    }

    public function logout(Request $request)
    {
        $token = $request->header("Authorization");
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 0,
                    'message'   => "Success"
                ],
                'data' => null
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 404,
                    'message'   => "Error"
                ],
                'data' => null
            ]);
        }
    }
}

