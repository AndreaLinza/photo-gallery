<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'album_name',
        'album_thumb',
        'description',
        'user_id',

    ];
    protected $garded = ['id'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getPathAttribute()
    {
        $url = $this->album_thumb;
        if(!str_starts_with($url,'http')){
            $url = "storage/" . $url;
        }
        return $url;
    }

}

