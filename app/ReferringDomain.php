<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferringDomain extends Model
{
    protected $fillable = [ 'domain' ];

    function views() {
        return $this->hasMany( View::class );
    }
}
