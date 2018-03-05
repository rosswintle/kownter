<?php

namespace App\Http\Controllers;

use App\Site;
use App\Page;
use Illuminate\Http\Request;
use App\ReferringDomain;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show($site)
    {
        $site = Site::with(['views', 'views.page', 'views.user_agent', 'views.site'])
            ->findOrFail($site);

        $topPages = \DB::table('pages')
            ->join('views', 'pages.id', '=', 'views.page_id')
            ->where('views.site_id', '=', $site->id)
            ->groupBy(['pages.id', 'pages.url'])
            ->orderByRaw('count(views.id) DESC')
            ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
            ->get();
        // Couldn't get this to work with Eloquent. Maybe something like:
        // $topPages = Page::withCount(['views' => function ($query) use ($site) { 
        //         $query->where('site_id', $site->id);
        //     }])
        //     ->where('views_count', '>', 0)
        //     ->orderBy('views_count', 'DESC')
        //     ->limit(10)
        //     ->get();

        $topReferrers = \DB::table('referring_domains')
            ->join('views', 'referring_domains.id', '=', 'views.referring_domain_id')
            ->where('views.site_id', '=', $site->id)
            ->groupBy(['referring_domains.id', 'referring_domains.domain'])
            ->orderByRaw('count(views.id) DESC')
           ->selectRaw('referring_domains.id, referring_domains.domain, count(views.id) as views_count')
            ->get();
            

        return view('site.show', [
            'site' => $site,
            'topPages' => $topPages,
            'topReferrers' => $topReferrers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
