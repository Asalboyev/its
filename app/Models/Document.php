<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'decs',
        'category_id',
        'vacancy_id',
        'phone'
    ];



    public function document_category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }


    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
    }

}
