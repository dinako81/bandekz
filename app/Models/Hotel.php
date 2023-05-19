<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['title', 'price',  'duration', 'photo'];
    public $timestamps = false;
    protected $casts = [
        'rates' => 'array',
    ];

    public function hotel()
    {
        return $this->hasMany(Photo::class);
    }

    
}