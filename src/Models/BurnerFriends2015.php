<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerFriends2015 extends Model
{
    protected $table      = 'BurnerFriends2015';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
    ];
}
