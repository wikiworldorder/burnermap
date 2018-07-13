<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerCamps2011 extends Model
{
    protected $table      = 'BurnerCamps2011';
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
