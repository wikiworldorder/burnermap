<?php namespace BurnerMap\Models;

use Illuminate\Database\Eloquent\Model;

// For integration with PhpList
class PhplistUser extends Model
{
    protected $table      = 'phplist_user_user';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable   = 
    [
        'email', 
        'confirmed', 
        'htmlemail', 
    ];
}
