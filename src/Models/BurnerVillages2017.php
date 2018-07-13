<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerVillages2017 extends Model
{
    protected $table      = 'BurnerVillages2017';
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
