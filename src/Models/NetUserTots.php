<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class NetUserTots extends Model
{
    protected $table      = 'NetUserTots';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
        'mapFriends',
        'camps',
    ];
}
