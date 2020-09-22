<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Todo extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['name','description','done'];



    public function user(){
        return $this->belongsTo('App\Models\User','creator_id');
    }

    // get user affected to this todo
    public function todoAffectedTo(){
        return $this->belongsTo('App\Models\User', 'affectedto_id');
    }

    // get user affected to this todo
    public function todoAffectedBy(){
        return $this->belongsTo('App\Models\User', 'affectedby_id');
    }
}
