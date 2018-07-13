<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageLoads2015 extends Model
{
    protected $table      = 'PageLoads2015';
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
