<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    
    function site() {
        return $this->belongsTo( 'site' );
    }

}
