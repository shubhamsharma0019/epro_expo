<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class VisitorProduct extends Model
{
    protected $table = 'visitor_products';
    protected $guarded = [];
 
    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }
}
