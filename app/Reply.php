<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];
    //
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A reply belongs to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

}
