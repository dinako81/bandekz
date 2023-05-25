<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\UploadedFile;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'season'];
    public $timestamps = false;

    public function hotel()
    {
        return $this->hasMany(Hotel::class);
    }

}