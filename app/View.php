<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [ 'site_id', 'user_agent_id', 'page_id' ];
    
    function site() {
        return $this->belongsTo( Site::class );
    }

    function user_agent() {
        return $this->belongsTo( UserAgent::class );
    }

    function page() {
        return $this->belongsTo( Page::class );
    }

}
