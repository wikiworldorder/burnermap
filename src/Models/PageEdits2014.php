<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits2014 extends Model
{
    protected $table      = 'PageEdits2014';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
