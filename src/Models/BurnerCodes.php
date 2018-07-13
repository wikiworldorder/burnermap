<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BurnerCodes extends Model
{
    protected $table      = 'BurnerCodes';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'code', 
    ];
}
