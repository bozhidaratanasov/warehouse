<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'image', 
        'buying_price', 
        'selling_price',
        'quantity',
        'category',
        'code'
    ];
}
