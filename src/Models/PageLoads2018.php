<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageLoads2018 extends Model
{
    protected $table      = 'PageLoads2018';
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
