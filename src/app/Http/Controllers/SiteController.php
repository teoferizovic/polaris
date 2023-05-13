<?php

namespace App\Http\Controllers;

use App\Repo\SiteRepo;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(SiteRepo $siterepo) {
        $server_details = $siterepo->details();

        dd($server_details);
    }
}
