<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'talk_id', 'talk_path', 'duration', 'image_id'];
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
