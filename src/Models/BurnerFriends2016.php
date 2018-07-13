<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerFriends2016 extends Model
{
    protected $table      = 'BurnerFriends2016';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
    ];
}
