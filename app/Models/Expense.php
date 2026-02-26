<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['colocation_id', 'user_id', 'title', 'amount', 'category', 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function colocation() { return $this->belongsTo(Colocation::class); }
}