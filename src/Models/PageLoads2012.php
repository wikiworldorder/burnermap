<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageLoads2012 extends Model
{
    protected $table      = 'PageLoads2012';
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
