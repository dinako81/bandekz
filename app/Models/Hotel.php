<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\UploadedFile;

class Hotel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['title', 'price',  'duration', 'photo', 'country_id',  'rate', 'rates'];
    public $timestamps = false;
    protected $casts = [
        'rates' => 'array',
    ];

    const SORT = [
        'default' => 'No sort',
        'price_0-50' => 'By price less 50$',
        'price_51-100' => 'By price 51-100$',
        'price_101-500' => 'By price 101-500$',
        'price_501-...' => 'By price more 501$',
    ];

    const FILTER = [
        'default' => 'Show all',
        'country' => 'Filter by country',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }


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

    public function photo()
    {
        return $this->hasMany(Photo::class);
    }

    public function gallery()
    {
        return $this->hasMany(Photo::class, 'hotel_id', 'id');
    }
    
}