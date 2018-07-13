<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class JerkCheck extends Model
{
    protected $table      = 'JerkCheck';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'campID', 
        'influence', 
        'infPerMem', 
    ];
}
