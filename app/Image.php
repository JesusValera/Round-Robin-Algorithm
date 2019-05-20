<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_team', 'source',
    ];

    /**
     * Get the team that owns the image.
     */
    public function teams()
    {
        return $this->belongsTo('App\Team');
    }
}
