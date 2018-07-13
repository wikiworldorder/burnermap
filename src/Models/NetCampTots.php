<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class NetCampTots extends Model
{
    protected $table      = 'NetCampTots';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'campID', 
        'influence', 
        'infPerMem', 
    ];
}
