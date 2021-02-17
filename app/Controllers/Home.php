<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index() {
        load_css('css_assets');
        return view('home');
    }
}
