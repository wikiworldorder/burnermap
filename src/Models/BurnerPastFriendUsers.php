<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerPastFriendUsers extends Model
{
    protected $table      = 'BurnerPastFriendUsers';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friendUsers', 
        'tot', 
    ];
}
