<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageLoads extends Model
{
    protected $table      = 'PageLoads';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'currUser', 
        'page',
        'ip',
        'browser',
        'date',
    ];
}
