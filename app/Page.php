<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [ 'url', 'site_id' ];

    function views() {
        return $this->hasMany( View::class );
    }

    function site() {
        return $this->belongsTo( Site::class );
    }

}
