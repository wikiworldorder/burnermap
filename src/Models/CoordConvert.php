<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class CoordConvert extends Model
{
    protected $table      = 'CoordConvert';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'addyClock', 
        'addyLetter', 
        'x', 
        'y', 
    ];
}
