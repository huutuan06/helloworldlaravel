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
    protected $numeral;
    use HasTimestamps;
    use UploadTrait;

    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->mModelBook = $book;
    }

    public function index()
    {
        $books = $this->mModelBook->get();
        $collections = collect();
        foreach ($books as $book) {
            $arr = array(
                'id' => $book->id,
                'title' => $book->title,
                'image' => $book->image,
                'category' => $this->mModelBook->getCategoryById($book->category_id)->name,
                'description' => $book->description,
                'content' => $book->content,
                'total_pages' => $book->total_pages,
                'price' => $book->price,
                'amount' => $book->amount,
                'author' => $book->author,
                'place_holder' => $book->place_holder,
                'manipulation' => $book->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    protected $imageBooScrawling;

    public function topSellingBook($yearBookSelling, $indexOf)
    {
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url = $yearBookSelling;
        $crawler = $goutteClient->request('GET', $url);
        $this->numeral = $indexOf;
        $crawler->filter('span.zg-item')->each(function ($node) {
            $image = $node->filter('a.a-link-normal > span.zg-text-center-align > div.a-section')->each(function ($node1) {
                $matches = array();
                preg_match('/https:(?=.*[!$#%\/]).*.jpg/', $node1->html(), $matches);
                return $matches[0];
            });
            $title = $node->filter('a.a-link-normal > div.p13n-sc-line-clamp-1')->each(function ($node2) {
                $getTitle = substr($node2->text(), 13, -9);
                return $getTitle;
            });
            if ($node->filter('div.a-size-small > a.a-link-child')->each(function ($node3) {
                }) != null) {
                $author = $node->filter('div.a-size-small > a.a-link-child')->each(function ($node3) {
                    return $node3->text();
                });
            } else {
                $author = $node->filter('div.a-size-small > span.a-color-base')->each(function ($node3) {
                    return $node3->text();
                });
            }
            //star rate
            $node->filter('div.a-spacing-none > a.a-link-normal > i.a-icon-star > span.a-icon-alt')->each(function ($node4) {
                return $node4->text();
            });

            $node->filter('div.a-spacing-none > a.a-size-small')->each(function ($node5) {
            });
            $node->filter('div.a-size-small > span.a-color-secondary')->each(function ($node6) {
            });
            if ($node->filter('div.a-row > a.a-link-normal > span.a-color-price > span.p13n-sc-price')->each(function ($node7) {
                }) != null) {
                $price = $node->filter('div.a-row > a.a-link-normal > span.a-color-price > span.p13n-sc-price')->each(function ($node7) {
                    return (float)substr(strstr($node7->text(), '$'), 1);
                });
            } else {
                $price = $node->filter('a.a-link-normal > span.a-color-secondary > span.a-size-base')->each(function ($node7) {
                    return (float)substr(strstr($node7->text(), '$'), 1);
                });
            }
            $this->numeral += 1;
            $book = array(
                'id' => self::resetOrderInDB(),
                'title' => $title[0],
                'numeral' => $this->numeral,
                'image' => $image[0],
                'category_id' => 3,
                'description' => '',
                'content' => '',
                'place_holder' => '',
                'total_pages' => 1,
                'price' => $price[0],
                'amount' => 100,
                'author' => $author[0],
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            );
            $this->mModelBook->synchWithServerFromLocal($book);
        });
    }

    /**
     * Order ID in User table
     * @return int
     */
    public function resetOrderInDB() {
        $i = 1;
        while (true){
            if ($this->mModelBook->getById($i) == null) break;
            $i++;
        }
        return $i;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('title', 'image', 'category_id', 'description', 'total_pages', 'price', 'amount', 'author');
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
            'category_id' => 'required',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'author' => 'required',
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
                        'category_id' => $request->category_id,
                        'description' => $request->description,
                        'total_pages' => $request->total_pages,
                        'price' => $request->price,
                        'amount' => $request->amount,
                        'author' => $request->author,
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
        $credentials = $request->only('title', 'image', 'description', 'total_pages', 'price', 'amount', 'author');
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'total_pages' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'author' => 'required'
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
            if ($this->mModelBook->getByTitle($request->title)) {
                if ($this->mModelBook->getByTitle($request->title)->id == $id) {
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
                    return json_encode(([
                        'message' => [
                            'status' => "invalid",
                            'description' => "The book already exists in the system!"
                        ]
                    ]));
                }
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

    public function showBooksByCategory(Request $request)
    {
        $books = $this->mModelBook->getByCategory($request->id);
        $collections = collect();
        foreach ($books as $book) {
            $arr = array(
                'id' => $book->id,
                'title' => $book->title,
                'image' => $book->image,
                'description' => $book->description,
                'total_pages' => $book->total_pages,
                'price' => $book->price,
                'amount' => $book->amount,
                'author' => $book->author
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }
}
