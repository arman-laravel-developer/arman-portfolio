<?php

namespace App\Http\Controllers;

use App\Models\VisitorInfo;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $ipAddress = $request->ip();
        $port = $_SERVER['SERVER_PORT'];

        // Getting MAC address locally (only works if exec() is enabled and allowed)
        $macAddress = exec('getmac'); // This works on Windows
        // For Unix/Linux, you might use `ifconfig` or `ip addr`
        // $macAddress = exec('ifconfig -a | grep ether');

        $client = new Client();
        $response = $client->get("https://ipinfo.io/{$ipAddress}/json");
        $ispDetails = json_decode($response->getBody(), true);

        // Save to database
        $visitorInfo = new VisitorInfo();
        $visitorInfo->ip = $ipAddress;
        $visitorInfo->port = $port;
        $visitorInfo->isp = $ispDetails['org'] ?? 'Unknown';
        $visitorInfo->mac = $macAddress;
        $visitorInfo->save();

        return view('front.home.home');
    }

    public function about()
    {
        $php = phpinfo();
        dd($php);
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
