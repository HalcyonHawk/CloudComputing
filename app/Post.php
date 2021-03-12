<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = [];
    protected $primaryKey = 'post_id';
    public $timestamps = false;

    public function getLastEditedFormattedAttribute()
    {
        return date_format(date_create($this->last_edited_date), 'd/m/Y');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'post_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
