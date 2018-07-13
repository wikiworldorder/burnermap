<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerFriends2011 extends Model
{
    protected $table      = 'BurnerFriends2011';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
    ];
}
