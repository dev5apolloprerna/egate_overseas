<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'country_id', 'visa_id', 'question', 'answer', 'iStatus', 'isDelete', 'strIP'
    ];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'country_id', 'iCountryId');
    }

    public function visa()
    {
        return $this->belongsTo(VisaMaster::class, 'visa_id', 'iVisaId');
    }
}
