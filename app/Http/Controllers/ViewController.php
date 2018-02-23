<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\View;

class ViewController extends Controller
{
    
    public function track( $domain ) {
        $view = new View;
        $site = Site::where( 'domain', $domain )->firstOrFail();
        $view->site = $site->id;
        $view->save();
    }

}
