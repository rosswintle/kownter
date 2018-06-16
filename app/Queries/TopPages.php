<?php

namespace App\Queries;

use App\Site;
use Carbon\Carbon;

class TopPages {

    static function get( $site )
    {
        return \DB::table('pages')
                ->join('views', 'pages.id', '=', 'views.page_id')
                ->where('pages.site_id', '=', $site->id)
                ->groupBy(['pages.id', 'pages.url'])
                ->orderByRaw('count(views.id) DESC')
                ->limit(10)
                ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
                ->get();
    }

    static function getWeek( $site )
    {
        return \DB::table('pages')
            ->join('views', 'pages.id', '=', 'views.page_id')
            ->where('pages.site_id', '=', $site->id)
            ->where('views.created_at', '>', Carbon::parse('-7 days')->toDateTimeString())
            ->groupBy(['pages.id', 'pages.url'])
            ->orderByRaw('count(views.id) DESC')
            ->limit(10)
            ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
            ->get();
    }

    static function getDay( $site )
    {
        return \DB::table('pages')
            ->join('views', 'pages.id', '=', 'views.page_id')
            ->where('pages.site_id', '=', $site->id)
            ->where('views.created_at', '>', Carbon::parse('-1 day')->toDateTimeString())
            ->groupBy(['pages.id', 'pages.url'])
            ->orderByRaw('count(views.id) DESC')
            ->limit(10)
            ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
            ->get();
    }


}