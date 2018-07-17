<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class AllPastUsers extends Model
{
    protected $table      = 'AllPastUsers';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'name', 
        'playaName', 
    ];
}
