<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class AllPastUsersDel extends Model
{
    protected $table      = 'AllPastUsersDel';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'name', 
        'playaName', 
        'totFriends',
    ];
}
