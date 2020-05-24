<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('colrs')->insert([
        [ 
          'name' => "color_1", 
          'colorName' => "Белый", 
          'hex' => "#ececec"
        ],
        [
          'name' => "color_2",
          'colorName' => "Желтый",
          'hex' => "#f1c928"
        ],
        [
          'name' => "color_3",
          'colorName' => "Синий",
          'hex' => "#1441ec"
        ],
        [
          'name' => "color_3",
          'colorName' => "Синий",
          'hex' => "#1441ec"
        ],
        [
          'name' => "color_4",
          'colorName' => "Оранжевый",
          'hex' => "#eb631f"
        ],
        [
          'name' => "color_5",
          'colorName' => "Зеленый",
          'hex' => "#74af39"
        ],
        [
          'name' => "color_6",
          'colorName' => "Голубой",
          'hex' => "#1288bd"
        ],
        [
          'name' => "color_7",
          'colorName' => "Розовый",
          'hex' => "#c82484"
        ],
        [
          'name' => "color_8",
          'colorName' => "Фиолетовый",
          'hex' => "#874ba7"
        ],
        [
          'name' => "color_9",
          'colorName' => "Зеленый",
          'hex' => "#56c4ab"
        ],
        [
          'name' => "color_10",
          'colorName' => "Коричневый",
          'hex' => "#976c4c"
        ],
        [
          'name' => "color_11",
          'colorName' => "Желтый",
          'hex' => "#f1e7c2"
        ],
        [
          'name' => "color_12",
          'colorName' => "Градиент",
          'hex' => "#FF6376"
        ],
    ]);
  }
}
