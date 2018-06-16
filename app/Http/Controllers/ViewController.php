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

        $site = $this->checkDomain( $refererDomain );

        $view->site()->associate( $site );

        $userAgentName = $request->header('user-agent');
        $userAgent = UserAgent::firstOrCreate([ 'name' => $userAgentName ]);
        $userAgent->addDetails();
        $view->user_agent()->associate($userAgent);

        $page = Page::firstOrCreate([ 'url' => $refererUrl ]);
        $page->site()->associate($site);
        $page->save();
        
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


    private function checkDomain( $refererDomain, $checkSubdomain = true )
    {
        $sites = Site::where('domain', $refererDomain)->get();

        if ($sites->count() == 0) {
            if ( $checkSubdomain ) {
                return $this->checkForSubdomain( $refererDomain );
            } else {
                abort(404, 'Could not find site from referer - this site is not tracked');
            }
        }

        return $sites->first();
    }

    private function checkForSubdomain( $refererDomain )
    {
        $hostParts = explode( '.', $refererDomain );
        
        if ( count( $hostParts ) > 2 ) {
            $domain = implode( '.', array_slice( $hostParts, 1 ) );
            return $this->checkDomain( $domain, false );
        }

        abort(404, 'Could not find site from referer - this site is not tracked');
    }

}
