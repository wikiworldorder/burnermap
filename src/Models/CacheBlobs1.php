<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheBlobs1 extends Model
{
    protected $table      = 'CacheBlobs1';
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
