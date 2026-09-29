<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'iCountryId',
        'iVisaId',
        'name',
        'designation',
        'description',
        'photo',
        'iStatus',
        'isDelete',
        'strIP'
    ];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'iCountryId', 'iCountryId');
    }

    public function visa()
    {
        return $this->belongsTo(VisaMaster::class, 'iVisaId', 'iVisaId');
    }
}
