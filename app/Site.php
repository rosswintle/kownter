<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Site extends Model
{
    protected $fillable = [ 'domain' ];

    function owner() {
        return $this->belongsTo( \App\User::class, 'user_id' );
    }

    function views() {
        return $this->hasMany( \App\View::class );
    }

    function pages() {
        return $this->hasMany( \App\Page::class );
    }

    function scopeUser( $query ) {
        if ($user = Auth::user()) {
            return $query->where( 'user_id', $user->id );
        } else {
            return $query->whereIn( 'user_id', [] );
        }
    }
}
