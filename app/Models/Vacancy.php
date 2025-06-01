<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'data',
        'desc',
        'price',
        'img',
        'views_count'
    ];

    protected $casts = [
        'title' => 'array',
        'desc' => 'array',
        'subtitle' => 'array'
    ];

    protected $appends = [
        'lg_img',
        'md_img',
        'sm_img'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getLgImgAttribute() {
        return $this->img ? url('').'/upload/images/'.$this->img : null;
    }

    public function getMdImgAttribute() {
        return $this->img ? url('').'/upload/images/600/'.$this->img : null;
    }

    public function getSmImgAttribute() {
        return $this->img ? url('').'/upload/images/200/'.$this->img : null;
    }
}
