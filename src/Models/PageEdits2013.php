<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits2013 extends Model
{
    protected $table      = 'PageEdits2013';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
