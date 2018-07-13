<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdits extends Model
{
    protected $table      = 'PageEdits';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'user', 
        'date', 
        'dump',
    ];
}
