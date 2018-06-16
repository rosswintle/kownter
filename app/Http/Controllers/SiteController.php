<?php

namespace App\Http\Controllers;

use App\Site;
use App\Page;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function show( Site $site )
    {
        if ( Auth::id() != $site->owner->id ) {
            abort(401);
        }

        $site = Site::with([
            'views' => function ($query) { return $query->limit(20)->orderBy('created_at', 'DESC'); }, 
            'views.page', 
            'views.user_agent', 
            'views.site'])
            ->findOrFail($site->id);

        $dayViews = View::daily()->where('site_id', $site->id)->count();
        $weekViews = View::weekly()->where('site_id', $site->id)->count();
        $allViews = View::where('site_id', $site->id)->count();

        $topPages = \DB::table('pages')
            ->join('views', 'pages.id', '=', 'views.page_id')
            ->where('pages.site_id', '=', $site->id)
            ->groupBy(['pages.id', 'pages.url'])
            ->orderByRaw('count(views.id) DESC')
            ->selectRaw('pages.id, pages.url, count(views.id) as views_count')
            ->get();

        $topPages = $topPages->map( function( $page ) {
            $page->path = parse_url( $page->url, PHP_URL_PATH );
            $page->domain = parse_url( $page->url, PHP_URL_HOST );
            return $page;
        }, $topPages );

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
            ->limit(20)
            ->get();
            
        $topBrowsers = \DB::table('user_agents')
            ->join('views', 'user_agents.id', '=', 'views.user_agent_id')
            ->where('views.site_id', '=', $site->id)
            ->groupBy(['user_agents.id', 'user_agents.name', 'user_agents.browser_name', 'user_agents.browser_version'])
            ->orderByRaw('count(views.id) DESC')
            ->selectRaw('user_agents.id, user_agents.name, user_agents.browser_name, user_agents.browser_version, count(views.id) as views_count')
            ->limit(20)
            ->get();
            

        return view('site.show', [
            'site' => $site,
            'dayViews' => $dayViews,
            'weekViews' => $weekViews,
            'allViews' => $allViews,
            'topPages' => $topPages,
            'topReferrers' => $topReferrers,
            'topBrowsers' => $topBrowsers,
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
