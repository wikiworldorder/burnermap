<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits2017 extends Model
{
    protected $table      = 'PageEdits2017';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
