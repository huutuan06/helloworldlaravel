<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Book;
use App\Traits\UploadTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;


class BookController extends Controller
{
    protected $mModelBook;
    use HasTimestamps;
    use UploadTrait;

    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->mModelBook = $book;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = $this->mModelBook->get();
        $collections = collect();
        foreach ($books as $book) {
            $arr = array(
                'id' => $book->id,
                'title' => $book->title,
                'image' => $book->image,
                'description' => $book->description,
                'total_pages' => $book->total_pages,
                'price' => $book->price,
                'manipulation' => $book->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageBooScrawling;

    public function topselling()
    {
        $this->mModelBook->deleteAllData();
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url = "https://www.amazon.com/gp/bestsellers/2019/books";
        $crawler = $goutteClient->request('GET', $url);
        $crawler->filter('span.zg-item')->each(function ($node) {
//            \Log::info("Link refer to books:".$node->filter('a.a-link-normal')->attr('href'));
            $image = $node->filter('a.a-link-normal > span.zg-text-center-align > div.a-section')->each(function ($node1) {
                $matches = array();
                preg_match('/https:(?=.*[!$#%\/]).*.jpg/', $node1->html(), $matches);
//                https:(?=.*[!$#%\/]).*.jpg
//                \Log::info($matches[0]);
                return $matches[0];
            });
            //title
            $title = $node->filter('a.a-link-normal > div.p13n-sc-line-clamp-1')->each(function ($node2) {
//                \Log::info(substr( $node2->text(),12,-9));
                $getTitle = substr($node2->text(), 13, -9);
                return $getTitle;
            });

            // If- Else. Author
            if ($node->filter('div.a-size-small > a.a-link-child')->each(function ($node3) {
                }) != null) {
                $author = $node->filter('div.a-size-small > a.a-link-child')->each(function ($node3) {
//                    \Log::info($node3->html());
                    return $node3->text();
                });
            } else {
                $author = $node->filter('div.a-size-small > span.a-color-base')->each(function ($node3) {
//                    \Log::info($node3->html());
                    return $node3->text();
                });
            }

            //star rate
            $node->filter('div.a-spacing-none > a.a-link-normal > i.a-icon-star > span.a-icon-alt')->each(function ($node4) {
//                \Log::info($node4->html());
                return $node4->text();
            });

            //total rate
            $node->filter('div.a-spacing-none > a.a-size-small')->each(function ($node5) {
//                \Log::info($node5->html());
            });
            //type (hardcover/ paperback/ mp3/ kindle)
            $node->filter('div.a-size-small > span.a-color-secondary')->each(function ($node6) {
//                \Log::info($node6->html());
            });
            //price
            $price = $node->filter('div.a-row > a.a-link-normal > span.a-color-price > span.p13n-sc-price')->each(function ($node7) {
//                \Log::info($node7->html());
                return $node7->text();
            });
            $book = array(
                'title' => $title[0],
                'image' => $image[0],
                'description' => '',
                'total_pages' => 1,
                'price' => $price[0],
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            );
            $this->mModelBook->add($book);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('title', 'image', 'description', 'total_pages', 'price');
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('title')) . '_' . time();
            // Define folder path
            $folder = '/images/books/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadImage($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $request->image = $filePath;
        }
        $rules = [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required',
        ];
        $customMessages = [
            'required' => 'The attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $this->response_array = ([
                'message' => [
                    'status' => 'invalid',
                    'description' => $validator->errors()->first()
                ]
            ]);
        } else {
            if ($this->mModelBook->getByTitle($request->title)) {
                $this->response_array = ([
                    'message' => [
                        'status' => 'invalid',
                        'description' => 'The book already exists in the system'
                    ]
                ]);
            } else {
                if ($this->mModelBook->add(array([
                        'title' => $request->title,
                        'image' => $request->image,
                        'description' => $request->description,
                        'total_pages' => $request->total_pages,
                        'price' => $request->price,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp(),
                    ])) > 0) {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'success',
                            'description' => 'Add a new book successfully'
                        ],
                        'book' => $this->mModelBook->getByTitle($request->title)
                    ]);
                }
            }
        }
        echo json_encode($this->response_array);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->mModelBook->getById($id);
        if ($book == null) {
            return json_encode([
                'message' => [
                    'status' => 'error',
                    'description' => "The book doesn't exist in the system!"
                ]
            ]);
        } else {
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => ''
                ],
                'book' => $book
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $credentials = $request->only('title', 'image', 'description', 'total_pages', 'price');
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form!'
        ];
        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            return json_encode(([
                'message' => [
                    'status' => "invalid",
                    'description' => $validator->errors()->first()
                ]
            ]));
        } else {
            if ($this->mModelBook->getById($request->id)->title == $request->title) {
                if ($request->image === null) {
                    $request->image = $this->mModelBook->getById($request->id)->image;
                } else {
                    $this->deleteImage('public', $this->mModelBook->getById($request->id)->image);
                    $image = $request->file('image');
                    $name = str_slug($request->input('title')) . '_' . time();
                    $folder = '/images/books/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $this->uploadImage($image, $folder, 'public', $name);
                    $request->image = $filePath;
                }
                $this->mModelBook->updateById($id, $request);

                return json_encode(([
                    'message' => [
                        'status' => "success",
                        'description' => "Update the book success!"
                    ],
                    'book' => $this->mModelBook->getById($id)
                ]));
            } else {
                if ($this->mModelBook->getByTitle($request->title)) {
                    return json_encode(([
                        'message' => [
                            'status' => "invalid",
                            'description' => "The book already exists in the system!"
                        ]
                    ]));
                } else {
                    $oldImage = $this->mModelBook->getById($request->id)->image;
                    if ($request->image === null) {
                        $request->image = $this->mModelBook->getById($request->id)->image;
                    } else {
                        $image = $request->file('image');
                        $name = str_slug($request->input('title')) . '_' . time();
                        $folder = '/images/books/';
                        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                        $this->uploadImage($image, $folder, 'public', $name);
                        $request->image = $filePath;
                    }
                    if ($this->mModelBook->updateById($id, $request) > 0) {
                        if ($request->image != null) {
                            $this->deleteImage('public', $oldImage);
                        }
                        return json_encode(([
                            'message' => [
                                'status' => "success",
                                'description' => "Update the book success!"
                            ],
                            'book' => $this->mModelBook->getById($id)
                        ]));
                    } else {
                        return json_encode(([
                            'message' => [
                                'status' => "error",
                                'description' => "Update the book failure!"
                            ]
                        ]));
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = $this->mModelBook->getById($id);
        $filename = $book->image;
        $this->mModelBook->deleteById($id);
        if ($this->mModelBook->getById($id) != null) {
            return json_encode([
                'message' => [
                    'status' => 'error',
                    'description' => 'Delete the book failure!'
                ]
            ]);
        } else {
            $this->deleteImage('public', $filename);
            return json_encode([
                'message' => [
                    'status' => 'success',
                    'description' => 'Delete the book successfully!'
                ],
                'id' => $id
            ]);
        }
    }
}
