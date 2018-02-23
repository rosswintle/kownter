<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [ 'domain' ];

    function views() {
        return $this->hasMany( \App\View::class );
    }
}
