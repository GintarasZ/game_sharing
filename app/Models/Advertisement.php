<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'subCategoryId',
        'productName',
        'productDescription',
        'productValue',
        'deposit',
        'priceForDay',
        'priceForThreeDays',
        'priceForWeek',
        'priceForMonth',
        'city',
        'photos'
    ];
}
