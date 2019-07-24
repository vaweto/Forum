<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    //
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite','favorited');
    }

    public function favorite()
    {
        $this->favorites()->create([
            'user_id' => auth()->id(),
        ]);
    }
}
