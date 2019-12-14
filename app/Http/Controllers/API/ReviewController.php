<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Review;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    protected $mModelReview;
    protected $mModelUser;
    use HasTimestamps;

    public function __construct(Review $review, User $user)
    {
        $this->mModelReview = $review;
        $this->mModelUser = $user;
    }

    public function reviews($book_id) {
        $reviews = $this->mModelReview->getByBookID($book_id);
        $result = array();
        foreach($reviews as $review) {
            $result[] = array(
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $this->mModelUser->getById($review->user_id)->name,
                'user_avatar' => $this->mModelUser->getById($review->user_id)->avatar,
                'book_id' => $review->book_id,
                'rate' => $review->rate,
                'content' => $review->content,
                'date' => $review->date,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at
            );
        }
        return response()->json([
            'http_response_code' => http_response_code(),
            'error' => [
                'code'        => 0,
                'message'   => "Success"
            ],
            'data' => $result
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
