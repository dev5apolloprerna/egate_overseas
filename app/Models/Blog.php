<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $primaryKey = 'iBlogId';
    public $timestamps = true;

    protected $fillable = [
        'strBlogTitle',
        'strBlogDescription',
        'strBlogImage',
        'strMetaTitle',
        'strMetaDescription',
        'strHead',
        'strFooter',
        'iStatus',
    ];

    protected $hidden = [
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at'
    ];
}
