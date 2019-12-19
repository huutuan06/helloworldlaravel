<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\Metas;
use App\Utilize\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Storage;
use Config;
use File;
use Image;

class CMSController extends Controller
{
    protected $mModelBook;
    protected $mModelMeta;
    protected $helper;
    use HasTimestamps;

    public function __construct(Book $book, Metas $meta, Helper $helper)
    {
        $this->middleware('auth');
        $this->mModelBook = $book;
        $this->mModelMeta = $meta;
        $this->helper = $helper;
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
            if ($request->bookPlaceholder =="https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/cms/data/placeholder_cms.png") {
                $response_array = ([
                    'message'       => [
                        'status'        => "invalid",
                        'description'   => "The image description is still blank. Please insert images."
                    ]
                ]);
                echo json_encode($response_array);
            } else {
                 if ($this->mModelBook->getById($request->bookID) != null) {
                     $item = $this->mModelBook->getById($request->bookID);
                     $this->mModelBook->updateById($request->bookID, array([
                         'id' => $request->bookID,
                         'title' => $item->title,
                         'numeral' => $item->numeral,
                         'image' => $item->image,
                         'category_id' => $item->category_id,
                         'description' => $request->bookDesc,
                         'content' => $request->bookContent,
                         'place_holder' => $request->bookPlaceholder,
                         'total_pages' => $item->total_pages,
                         'price' => $item->price,
                         'amount' => $item->amount,
                         'author' => $item->author,
                         'created_at' => $this->freshTimestamp(),
                         'updated_at' => $this->freshTimestamp()
                     ]));
                 }
                 if ($this->mModelMeta->getItemByBookID($request->bookID) != null) {
                    $this->mModelMeta->update([
                        'id' => $this->mModelMeta->getItemByBookID($request->bookID)->id,
                        'title' => $request->title,
                        'referrer' => $request->referrer,
                        'description' => $request->bookDesc,
                        'keywords' => $request->keywords,
                        'author' => $request->author,
                        'theme_color' => $request->theme_color,
                        'og_title' => $request->og_title,
                        'og_image' => $request->og_image,
                        'og_url' => $request->og_url,
                        'og_site_name' => $request->og_site_name,
                        'og_description' => $request->og_description,
                        'fb_app_id' => $request->fb_app_id,
                        'twitter_card' => $request->twitter_card,
                        'twitter_title' => $request->twitter_title,
                        'twitter_description' => $request->twitter_description,
                        'twitter_url' => $request->twitter_url,
                        'twitter_image' => $request->twitter_image,
                        'parsely_link' => $request->parsely_link,
                        'bookID' => $request->bookID
                    ]);
                 } else {
                     $this->mModelMeta->add([
                         'id' => 0,
                         'title' => $request->title,
                         'referrer' => $request->referrer,
                         'description' => $request->description,
                         'keywords' => $request->keywords,
                         'author' => $request->author,
                         'theme_color' => $request->theme_color,
                         'og_title' => $request->og_title,
                         'og_image' => $request->og_image,
                         'og_url' => $request->og_url,
                         'og_site_name' => $request->og_site_name,
                         'og_description' => $request->og_description,
                         'fb_app_id' => $request->fb_app_id,
                         'twitter_card' => $request->twitter_card,
                         'twitter_title' => $request->twitter_title,
                         'twitter_description' => $request->twitter_description,
                         'twitter_url' => $request->twitter_url,
                         'twitter_image' => $request->twitter_image,
                         'parsely_link' => $request->parsely_link,
                         'bookID' => $request->bookID
                     ]);
                 }
            }
        }
        echo json_encode([
            'message'       => [
                'status'        => "success",
                'description'   => "Update content of book successfully."
            ]
        ]);
    }

    public function placeholder(Request $request)
    {
        $request->place_holder = '';
        if (isset($_FILES['bookPlaceholder']['tmp_name'])) {
            if (!file_exists($_FILES['bookPlaceholder']['tmp_name']) || !is_uploaded_file($_FILES['bookPlaceholder']['tmp_name'])) {
                $request->place_holder = 'https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/cms/data/placeholder_cms.png';
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
                Storage::disk('s3')->put(Config::get('constants.options.placeholder') . '/' . $key, fopen($request->file('bookPlaceholder'), 'r+'), 'public');
                $request->place_holder = preg_replace("/^http:/i", "https:", Storage::disk('s3')->url(Config::get('constants.options.placeholder') . '/' . $key));
            }
        }
        $response_array = ([
            'place_holder'      => $request->place_holder,
            'message'       => [
                'status'        => "success",
                'description'   => "Upload place holder successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function resource_cms() {
        // Allowed origins to upload images
        $accepted_origins = array("https://vogobook.luisnguyen.com", "http://vogobook.luisnguyen.com");

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
            $target = "images/media/" . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $target);
            $key = time().strstr($target, '.');
            Storage::disk('s3')->put(Config::get('constants.options.placeholder') . '/' . $key, File::get($target), 'public');
            $this->place_holder = preg_replace("/^http:/i", "https:", Storage::disk('s3')->url(Config::get('constants.options.placeholder') . '/' . $key));
            File::delete(File::get($target));
            echo json_encode(([
                    'location'      => $this->place_holder
            ]));
        } else {
            header("HTTP/1.1 500 Server Error");
        }
    }
}
