<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    protected $fillable = [
        'exhibition_id',
        'hall_name',
        'booth_number',
        'name',
        'category',
        'description',
        'website',
        'email',
        'country',
        'rep_name',
        'rep_title',
        'rep_email',
        'rep_phone',
        'rep_img_url',
        'logo_color',
        'logo_text'
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function meetings()
    {
        return $this->hasMany(ExhibitionMeeting::class);
    }
}
