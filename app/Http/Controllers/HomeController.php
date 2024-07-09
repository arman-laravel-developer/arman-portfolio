<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {

        $macAddress = exec('getmac');
        dd($macAddress);
        return view('front.home.home');
    }

    public function about()
    {
        return view('front.pages.about');
    }

    public function works()
    {
        return view('front.pages.works');
    }

    public function blog()
    {
        return view('front.pages.blog');
    }

    public function contact()
    {
        return view('front.pages.contact');
    }


}
