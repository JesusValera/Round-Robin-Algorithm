<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image';

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
