<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits2018 extends Model
{
    protected $table      = 'PageEdits2018';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
