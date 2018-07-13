<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheBlobs2 extends Model
{
    protected $table      = 'CacheBlobs2';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'type', 
        'date', 
        'user', 
        'friends', 
        'blobber', 
        'uniqueKey', 
    ];
}
