<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

class TextSettings extends Model
{
    protected $table      = 'TextSettings';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'type', 
        'year', 
        'value',
    ];
}
