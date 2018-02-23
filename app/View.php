<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    
    function site() {
        return $this->belongsTo( Site::class );
    }

    function user_agent() {
        return $this->belongsTo( UserAgent::class );
    }

}
