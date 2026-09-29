<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaMaster extends Model
{
    use HasFactory;

    protected $table = 'visa_master';
    protected $primaryKey = 'iVisaId';
    public $timestamps = true;

    protected $fillable = [
        'iVisaId', 'strVisaName', 'strSlug', 'strH1Tag', 'strPhoto', 'strDescription','iStatus','isDelete','created_at','updated_at',
    ];

    public function visaservices()
    {
        return $this->hasMany(VisaServices::class, 'iVisaId', 'iVisaId')->where('isDelete', 0);
    }

}

