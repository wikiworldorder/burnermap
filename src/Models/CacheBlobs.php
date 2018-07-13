<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheBlobs extends Model
{
    protected $table      = 'CacheBlobs';
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
