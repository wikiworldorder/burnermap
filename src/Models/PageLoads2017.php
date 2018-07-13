<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageLoads2017 extends Model
{
    protected $table      = 'PageLoads2017';
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
