<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class NetDists extends Model
{
    protected $table      = 'NetDists';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'camp1', 
        'tblRow', 
    ];
}
