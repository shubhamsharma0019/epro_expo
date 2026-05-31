<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class VisitorPavilion extends Model
{
    protected $table = 'visitor_pavilions';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}
