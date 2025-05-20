<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils';

    protected $fillable = [
        'plat_number',
        'category',
        'merk',
        'model',
        'year',
        'transmission',
        'seat',
        'description',
        'status',
        'price',
        'picture_upload',
    ];
}
