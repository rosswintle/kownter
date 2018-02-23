<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\View;
use App\UserAgent;
use App\Page;

class ViewController extends Controller
{
    
    public function track( Request $request, $domain ) {
        $view = new View;

        $site = Site::where( 'domain', $domain )->firstOrFail();
        $view->site()->associate($site);

        $userAgentName = $request->header('user-agent');
        $userAgent = UserAgent::firstOrCreate([ 'name' => $userAgentName ]);
        $view->user_agent()->associate($userAgent);

        $refererUrl = $request->header('referer');
        if ( $refererUrl ) {
            $page = Page::firstOrCreate([ 'url' => $refererUrl ]);
            $view->page()->associate($page);
        }

        $view->save();

        return '';
    }

}
