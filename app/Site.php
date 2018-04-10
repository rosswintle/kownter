<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [ 'domain' ];

    function views() {
        return $this->hasMany( \App\View::class );
    }

    function pages() {
        return $this->hasMany( \App\Page::class );
    }
}
