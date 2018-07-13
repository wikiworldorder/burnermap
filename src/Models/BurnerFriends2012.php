<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerFriends2012 extends Model
{
    protected $table      = 'BurnerFriends2012';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
    ];
}
