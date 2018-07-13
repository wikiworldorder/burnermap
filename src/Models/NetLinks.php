<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class NetLinks extends Model
{
    protected $table      = 'NetLinks';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'camp1', 
        'camp2', 
        'bond', 
    ];
}
