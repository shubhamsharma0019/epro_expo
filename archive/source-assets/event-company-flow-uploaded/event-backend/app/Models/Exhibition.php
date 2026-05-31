<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'venue',
        'description',
        'banner_url',
        'companies_count'
    ];

    public function exhibitors()
    {
        return $this->hasMany(Exhibitor::class);
    }

    public function visitors()
    {
        return $this->hasMany(ExhibitionVisitor::class);
    }
}
