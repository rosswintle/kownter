<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    protected $fillable = [ 'name' ];

    function views() {
        return $this->hasMany( View::class );
    }
}
