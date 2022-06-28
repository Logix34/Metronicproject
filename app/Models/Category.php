<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'banner_image',
        'square_image'
    ];
    public function categories(){
        return $this->hasMany(SubCategory::class);
    }
}
