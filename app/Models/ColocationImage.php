<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColocationImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'image_path',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}