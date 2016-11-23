<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \App\User;
class Message extends Model
{
    protected $fillable =[
        'user_id',
        'message',
        'published_at'
    ];
    public function scopePublished($query){
//        $query->where('published_at','>=', Carbon::now());

    }
    public function setPublishedAtAttribute(){
        $this->attributes['published_at']=Carbon::now();
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function teams(){
        return $this->belongsToMany('App\Team')->withTimestamps();
    }

}
