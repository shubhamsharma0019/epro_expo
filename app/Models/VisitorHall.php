<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class VisitorHall extends Model
{
    protected $table = 'visitor_halls';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}
