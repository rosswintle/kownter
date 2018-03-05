<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\View;
use App\UserAgent;
use App\Page;
use App\ReferringDomain;

class ViewController extends Controller
{
    
    public function track( Request $request ) {
        $view = new View;

        $refererUrl = $request->header( 'referer' );

        if (! is_string( $refererUrl ) ) {
            abort( 400 );
        }
        
        $refererDomain = parse_url( $refererUrl, PHP_URL_HOST );

        if (! $refererDomain ) {
            abort( 404 );
        }

        $site = Site::where( 'domain', $refererDomain )->firstOrFail();
        $view->site()->associate( $site );

        $userAgentName = $request->header('user-agent');
        $userAgent = UserAgent::firstOrCreate([ 'name' => $userAgentName ]);
        $view->user_agent()->associate($userAgent);

        $page = Page::firstOrCreate([ 'url' => $refererUrl ]);
        $view->page()->associate($page);

        if ( $request->has('referrer') ) {
            $sourceReferrer = $request->input('referrer');
            $sourceReferringDomain = parse_url($sourceReferrer, PHP_URL_HOST);
            if ( $sourceReferringDomain ) {
                $sourceReferringDomain = ReferringDomain::firstOrCreate( [ 
                    'domain' => $sourceReferringDomain,
                ] );
                $view->referring_domain()->associate( $sourceReferringDomain );
            }
        }

        $view->save();

        return response('')
            ->header('Access-Control-Allow-Origin', $request->header('origin') );
    }

}
