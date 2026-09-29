<?php
// app/Models/SpecialityOtherDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaServices extends Model
{
    protected $table = 'visa_service_master';
    protected $primaryKey = 'iVisaServiceId';
    public $timestamps = true;

    protected $fillable = [
        'iVisaServiceId', 'iVisaId', 'strTitle', 'strPhoto', 'strDescription', 'iStatus', 'isDelete', 'created_at', 'updated_at'
    ];

    public function visa()
    {
        return $this->belongsTo(VisaMaster::class, 'iVisaId', 'iVisaId');
    }
}
