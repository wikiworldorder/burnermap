<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialCampsAPI extends Model
{
    protected $table      = 'OfficialCampsAPI';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'uid', 
        'name', 
        'url',
        'description',
        'hometown',
        'addyClock',
        'addyLet',
    ];
}
