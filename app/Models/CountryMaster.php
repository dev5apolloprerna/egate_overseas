<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryMaster extends Model
{
    use HasFactory;

    protected $table = 'country_master';
    protected $primaryKey = 'iCountryId';
    public $timestamps = true;

    protected $fillable = [
        'iCountryId', 'strCountryName', 'strSlug', 'strH1Tag', 'strPhoto', 'strDescription','iStatus','isDelete','created_at','updated_at',
    ];

    public function countryservices()
    {
        return $this->hasMany(CountryServices::class, 'iCountryId', 'iCountryId')->where('isDelete', 0);
    }

}

