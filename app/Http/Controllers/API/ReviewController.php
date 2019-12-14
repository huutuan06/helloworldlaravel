<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Review;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;


class ReviewController extends Controller
{
    protected $mModelReview;
    use HasTimestamps;

    public function __construct(Review $review)
    {
        $this->middleware('auth');
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
}
