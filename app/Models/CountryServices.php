<?php
// app/Models/SpecialityOtherDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryServices extends Model
{
    protected $table = 'country_service_master';
    protected $primaryKey = 'iCountryServiceId';
    public $timestamps = true;

    protected $fillable = [
        'iCountryServiceId', 'iCountryId', 'strTitle', 'strPhoto', 'strDescription', 'iStatus', 'isDelete', 'created_at', 'updated_at'
    ];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'iCountryId', 'iCountryId');
    }
}
