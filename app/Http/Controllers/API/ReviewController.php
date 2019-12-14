<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Review;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    protected $mModelReview;
    use HasTimestamps;

    public function __construct(Review $review)
    {
        $this->mModelReview = $review;
    }

    public function reviews($book_id) {
        return response()->json([
            'http_response_code' => http_response_code(),
            'error' => [
                'code'        => 0,
                'message'   => "Success"
            ],
            'data' => $this->mModelReview->getByBookID($book_id)
        ]);
    }

    public function add_review(Request $request) {
        if ($this->mModelReview->add(array([
            'id' => 0,
            'user_id' => JWTAuth::user()->id,
            'book_id' => $request->book_id,
            'rate' => $request->rate,
            'content' => $request->review,
            'date' => $request->date,
            'created_at' => $this->freshTimestamp(),
            'updated_at' => $this->freshTimestamp(),
        ])) > 0) {
            return response()->json([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 0,
                    'message'   => "Success"
                ],
                'data' => null
            ]);
        } else {
            return response()->json([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 40001,
                    'message'   => "Success"
                ],
                'data' => null
            ]);
        }
    }
}
