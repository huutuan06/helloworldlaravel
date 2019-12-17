<?php

namespace App\Utilize;

use App\Http\Controllers\Controller;
use Validator;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
/**
 * Created by PhpStorm.
 * User: vuongluis
 * Date: 4/22/2018
 * Time: 3:10 PM
 */
class Helper extends Controller
{
    public function validateQuestion($request) {
        $this->validate(
            $request,
            ['question' => 'required'],
            ['question.required' => 'Tên câu hỏi không được bỏ trống!']
        );
    }

    public function establishStatusOnline(Request $request) {
        $user = JWTAuth::toUser($request->header('Authorization'));
        $expiresAt = Carbon::now()->addMinute(1);
        Cache::put('user-is-online-'.$user->id, true, $expiresAt);
    }

    public function ip_info($ip = NULL, $purpose = "geoplugin_countryCode") {
        $this->requestGuzzle = new Client();
        $output = NULL;
        $res = $this->requestGuzzle->get('http://www.geoplugin.net/json.gp?ip='.$ip, []);
        $statusCode = $res->getStatusCode();
        if ($statusCode == 200) {
            $specifyLocal = json_decode($res->getBody(), true);
            $output = $specifyLocal[$purpose];
        }
        return $output;
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}