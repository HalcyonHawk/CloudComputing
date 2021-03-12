<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];
    protected $primaryKey = 'comment_id';

    public function getLastEditedFormattedAttribute()
    {
        return date_format(date_create($this->last_edited_date), 'd/m/Y');
    }

    public function user()
    {
        return $this->belongsTo('App/User', 'user_id', 'user_id');
    }

    public function post()
    {
        return $this->belongsTo('App/Post', 'post_id', 'post_id');
    }
}
