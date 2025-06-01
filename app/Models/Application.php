<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'vacancy_id',
        'phone_number',
        'message',
        'type',
        'page',
        'company'
    ];
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

}
