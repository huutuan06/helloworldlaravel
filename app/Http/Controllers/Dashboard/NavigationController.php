<?php

namespace App\Http\Controllers\Dashboard;

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
}
