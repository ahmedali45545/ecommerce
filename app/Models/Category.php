<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = ['name'];

    protected $with =['translations'];

    protected $fillable = ['slug','is_active','parent_id'];

    protected $casts =[
        'is_translatable'=>'boolean',
        'is_active'=>'boolean',
    ];
    public $timestamps =false;
    




    public static function setMany($categories)
    {
        foreach ($categories as $key => $value) {
            self::set($key, $value);
        }
    }



    public static function set($key, $value)
    {
        if ($key === 'translatable') {
            return static::setTranslatableSettings($value);
        }

        if(is_array($value))
        {
            $value = json_encode($value);
        }

        static::updateOrCreate( ['slug' => $value],['is_active' => false]);
    }


    public static function setTranslatableSettings($categories = [])
    {
        foreach ($categories as $key => $value) {
            static::updateOrCreate(['slug' => $key], ['name' => $value]);
        }
    }
}
