<?php
 
namespace App\Domain\Visitor\Models;
 
use App\Domain\Company\Models\Exhibitor;
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
