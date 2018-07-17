<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class BlockUsers extends Model
{
    protected $table      = 'BlockUsers';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'blocks', 
    ];
}
