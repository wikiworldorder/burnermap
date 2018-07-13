<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits2012 extends Model
{
    protected $table      = 'PageEdits2012';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
