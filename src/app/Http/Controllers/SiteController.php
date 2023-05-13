<?php

namespace App\Http\Controllers;

use App\Repo\SiteRepo;
use App\Repo\SiteRepo2;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(SiteRepo $siterepo, SiteRepo2 $siterepo2) {
        $server_details = $siterepo->details();
        $server_details2 = $siterepo2->details();

        //dd($server_details);
        dd($server_details2);
    }
}
