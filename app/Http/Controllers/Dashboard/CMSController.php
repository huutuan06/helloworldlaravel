<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Storage;
use Config;


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

    public function placeholder(Request $request)
    {
        $request->place_holder = '';
        if (isset($_FILES['bookPlaceholder']['tmp_name'])) {
            if (!file_exists($_FILES['bookPlaceholder']['tmp_name']) || !is_uploaded_file($_FILES['bookPlaceholder']['tmp_name'])) {
                $request->avatar = 'https://vogobook.s3-ap-southeast-1.amazonaws.com/cms/placeholder_cms.png';
            } else {
                $fileExt = $request->file('bookPlaceholder')->getClientOriginalName();
                $fileName = pathinfo($fileExt, PATHINFO_FILENAME);
                $info = pathinfo($_FILES['bookPlaceholder']['name']);
                if (preg_match("/^.*picture.*$/", $info['filename']) == 0) {
                    $ext = $info['extension'];
                } else {
                    $ext = 'png';
                }
                $key = $this->helper->clean(trim(strtolower($fileName)) . "_" . time()) . "." . $ext;
                Storage::disk('s3')->put(Config::get('constants.options.placeholder') . '/' . $key, fopen($request->file('avatar'), 'r+'), 'public');
                $request->place_holder = preg_replace("/^http:/i", "https:", Storage::disk('s3')->url(Config::get('constants.options.placeholder') . '/' . $key));
            }
        }
        $response_array = ([
            'place_holder'      => $request->place_holder,
            'message'       => [
                'status'        => "success",
                'description'   => "Upload image successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function resource_cms() {
        // Allowed origins to upload images
        $accepted_origins = array("https://vogobook.luisnguyen.com", "http://vogobook.luisnguyen.com");

        // Images upload path
        $imageFolder = "images/media/";

        reset($_FILES);
        $temp = current($_FILES);
        if(is_uploaded_file($temp['tmp_name'])){
            if(isset($_SERVER['HTTP_ORIGIN'])){
                // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else{
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            // Sanitize input
            if(preg_match("/([^\\w\\s\\d\\-_~,;:\\[\\]\\(\\).])|([\\.]{2,})/", $temp['name'])){
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Verify extension
            if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . time() .'_'. $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);
            $fileContent = File::get($filetowrite);
            $absolutePath = public_path().'/'.$filetowrite;
            ini_set('memory_limit', '-1');
            Image::make($absolutePath)->resize('512', '288')->save($absolutePath);
            $res = $this->requestGuzzle->post('https://topicsoverflow.com/backend/articles/media/image', [
                'multipart' => [
                    [
                        'name' => 'mediaImage',
                        'contents' => $fileContent,
                        'filename' => basename($filetowrite)
                    ],
                    [
                        'name' => 'email',
                        'contents' => 'ezblog@luisnguyen.com',
                    ],
                    [
                        'name' => 'password',
                        'contents' => 'Abc@123456',
                    ]
                ],
            ]);
            $statusCode = $res->getStatusCode();
            if ($statusCode == 200) {
                File::delete($filetowrite);
                echo $res->getBody();
            }
        } else {
            header("HTTP/1.1 500 Server Error");
        }
    }
}
