<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerVillages2014 extends Model
{
    protected $table      = 'BurnerVillages2014';
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
    ];
}
