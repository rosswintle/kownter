<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Carbon\Carbon;

class TopPagesApiController extends Controller
{
    function showWeek( Site $site ) {
        $topPages = \DB::table('pages')
            ->join('views', 'pages.id', '=', 'views.page_id')
            ->where('pages.site_id', '=', $site->id)
            ->where('views.created_at', '>', Carbon::parse('-7 days')->toDateTimeString())
            ->groupBy(['pages.id', 'pages.url'])
            ->orderByRaw('count(views.id) DESC')
            ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
            ->get();

        return $topPages;
    }
}
