<?php

namespace App\Models;

use App\Models\Hotel;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class Hotel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['title', 'price',  'duration', 'photo'];
    public $timestamps = false;
    protected $casts = [
        'rates' => 'array',
    ];


    public function deletePhoto()
    {
        if ($this->photo) {
            $photo = public_path() . '/hotels-photo/' . $this->photo;
            unlink($photo);
            $photo = public_path() . '/hotels-photo/t_' . $this->photo;
            unlink($photo);
        }
        $this->update([
            'photo' => null,
        ]);
    }

    public function savePhoto(UploadedFile $photo) : string
    {
        $name = $photo->getClientOriginalName();
        $name = rand(1000000, 9999999) . '-' . $name;
        $path = public_path() . '/hotels-photo/';
        $photo->move($path, $name);
        $img = Image::make($path . $name);
        $img->resize(200, 200);
        $img->save($path . 't_' . $name, 90);
        return $name;
    }

    public function hotel()
    {
        return $this->hasMany(Photo::class);
    }

    
}