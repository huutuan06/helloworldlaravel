<?php

namespace App\Http\Controllers\Dashboard;

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
}
