<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerCamps2013 extends Model
{
    protected $table      = 'BurnerCamps2013';
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
