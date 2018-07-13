<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerCamps2014 extends Model
{
    protected $table      = 'BurnerCamps2014';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'name', 
        'x', 
        'y', 
        'addyClock', 
        'addyLetter', 
        'addyLetter2', 
        'size', 
        'who', 
        'needCampers', 
        'villageID', 
        'apiID', 
    ];
}
