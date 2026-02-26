<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['colocation_id', 'from_user_id', 'to_user_id', 'amount'];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}