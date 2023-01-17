<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::setMany([
            'clothes',
            'furniture',
            'elctronics' ,
            'phones',
            'vehicles' ,
            'school supplies',
            'translatable' => [
                'clothes' => ' ملابس',
                'furniture' => 'اثاث منزلى ',
                'elctronics' => ' الكترونيات',
                'phones' => 'موبيلات ',
                'vehicles'=>'مركبات',
                'school supplies'=>'ادوات مكتبية',
            ],
        ]);
    }
}
