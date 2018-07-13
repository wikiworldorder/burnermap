<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CacheAuto extends Model
{
    protected $table      = 'CacheAuto';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'typing', 
        'blobber', 
    ];
}
