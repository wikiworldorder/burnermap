<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerFriends2018 extends Model
{
    protected $table      = 'BurnerFriends2018';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'friends', 
    ];
}
