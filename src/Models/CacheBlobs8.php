<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheBlobs8 extends Model
{
    protected $table      = 'CacheBlobs8';
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
