<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;

class NavigationController extends Controller
{

    public function __construct() {
    }

    /**
     * Ajax, using those methods to navigate to Page in DashBoard screen
     */
    public function dashboard() {
        $returnHTML = view('ajax.page.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function book() {
        $returnHTML = view('ajax.page.book.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function category() {
        $returnHTML = view('ajax.page.category.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function user() {
        $returnHTML = view('ajax.page.user.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }
}
