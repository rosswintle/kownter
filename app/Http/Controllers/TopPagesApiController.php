<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Carbon\Carbon;
use App\Queries\TopPages;

class TopPagesApiController extends Controller
{

    function show( Site $site )
    {
        return TopPages::get( $site );
    }

    function showWeek( Site $site )
    {
        return TopPages::getWeek( $site );
    }

}
