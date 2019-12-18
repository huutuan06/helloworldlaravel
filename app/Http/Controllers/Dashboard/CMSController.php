<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Book;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;


class CMSController extends Controller
{
    protected $mModelBook;
    use HasTimestamps;

    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->mModelBook = $book;
    }

    public function cms(Request $request) {
        $credentials = $request->only('slugTitle','bookDesc','bookContent');
        $rules = [
            'slugTitle' => 'required',
            'bookDesc' => 'required',
            'bookContent' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            if ($validator->errors()->get('slugTitle') != null) {
                $response_array = ([
                    'message'       => [
                        'status'        => "invalid",
                        'description'   => "The title is still blank. Please fill in the field."
                    ]
                ]);
                echo json_encode($response_array);
            } else if ($validator->errors()->get('bookDesc') != null) {
                $response_array = ([
                    'message'       => [
                        'status'        => "invalid",
                        'description'   => "The description is still blank. Please fill in the field."
                    ]
                ]);
                echo json_encode($response_array);
            } else if ($validator->errors()->get('bookContent') != null) {
                $response_array = ([
                    'message'       => [
                        'status'        => "invalid",
                        'description'   => "The content is still blank. Please fill in the field."
                    ]
                ]);
                echo json_encode($response_array);
            }
        } else {
            if ($request->bookPlaceholder =="http://topicsoverflow.com/images/img_placeholder.png") {
                $response_array = ([
                    'message'       => [
                        'status'        => "invalid",
                        'description'   => "The image description is still blank. Please insert images."
                    ]
                ]);
                echo json_encode($response_array);
            } else {
                \Log::info($request);
//                if($this->modelArticle->isExistItem($request)) {
//                    $response_array = ([
//                        'message'       => [
//                            'status'        => "existed",
//                            'description'   => "The article already exists in the system."
//                        ]
//                    ]);
//                } else {
//                    if ($this->modelArticle->addAll($this->getInfoArticle($request)) > 0) {
//                        $articleID = $this->modelArticle->getItemByTitle($request->articleTitle)->id;
//                        self::updateImageAfterAdjustArticle($request->articleImage, $articleID);
//                        self::updateMediaAfterAdjustArticle($request, $articleID);
//                        $response_array = ([
//                            'message'       => [
//                                'status'        => "success",
//                                'description'   => "Add article to be successful."
//                            ]
//                        ]);
//                    } else {
//                        $response_array = ([
//                            'message'       => [
//                                'status'        => "error",
//                                'description'   => "Add article failed."
//                            ]
//                        ]);
//                    }
//                }
//                echo json_encode($response_array);
            }
        }
    }
}
