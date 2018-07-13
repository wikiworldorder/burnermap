<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class Totals extends Model
{
    protected $table      = 'Totals';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'type', 
        'value',
    ];
}
