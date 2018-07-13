<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheBlobs0 extends Model
{
    protected $table      = 'CacheBlobs0';
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
