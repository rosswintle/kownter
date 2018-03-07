<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    function referring_domain() {
        return $this->belongsTo( ReferringDomain::class );
    }

    function scopeDaily( $query ) {
        $yesterday = new Carbon('-24 hours');
        return $query->where('created_at', '>', $yesterday->toDateTimeString());
    }

    function scopeWeekly($query) {
        $lastWeek = new Carbon('-1 week');
        return $query->where('created_at', '>', $lastWeek->toDateTimeString());
    }

}
