<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'address',
    ];

    public function images()
    {
        return $this->hasMany(ColocationImage::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}