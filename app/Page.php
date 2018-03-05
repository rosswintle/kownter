<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [ 'url' ];

    function views() {
        return $this->hasMany( View::class );
    }

}
