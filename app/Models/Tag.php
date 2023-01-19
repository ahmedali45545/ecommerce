<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    use Translatable;

    
    protected $with = ['translations'];


    protected $translatedAttributes = ['name'];

    
    protected $fillable = ['slug'];

    
    protected $hidden = ['translations'];
}
