<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageStats extends Model
{
    protected $table      = 'PageStats';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'day', 
        'loads', 
        'loadsU',
        'edits',
        'editsU',
        'newUsers',
    ];
}
