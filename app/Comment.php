<?php

namespace App;
use App\Communitypost;
use App\Nieuwspost;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function nieuwspost(){
        return $this->belongsTo('App\Nieuwspost');
    }
    
    public function communitypost(){
        return $this->belongsTo('App\Communitypost');
    }
    
    public function resourcepost(){
        return $this->belongsTo('App\Resourcepost');
    }
    
}