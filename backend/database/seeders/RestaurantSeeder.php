<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurant::insert([
            [
                'name' => 'Warsaw Pizza House',
                'latitude' => 52.2297,
                'longitude' => 21.0122,
                'category' => 'pizza',
                'rating' => 4.7,
                'album_number' => '79000',
            ],
            [
                'name' => 'Krakow Sushi Bar',
                'latitude' => 50.0647,
                'longitude' => 19.9450,
                'category' => 'sushi',
                'rating' => 4.8,
                'album_number' => '79000',
            ],
            [
                'name' => 'Katowice Burger Point',
                'latitude' => 50.2649,
                'longitude' => 19.0238,
                'category' => 'burger',
                'rating' => 4.5,
                'album_number' => '79000',
            ],
            [
                'name' => 'Gdansk Vegan Kitchen',
                'latitude' => 54.3520,
                'longitude' => 18.6466,
                'category' => 'vegan',
                'rating' => 4.6,
                'album_number' => '79000',
            ],
            [
                'name' => 'Poznan Pizza Corner',
                'latitude' => 52.4064,
                'longitude' => 16.9252,
                'category' => 'pizza',
                'rating' => 4.3,
                'album_number' => '79000',
            ],
            [
                'name' => 'Wroclaw Sushi Express',
                'latitude' => 51.1079,
                'longitude' => 17.0385,
                'category' => 'sushi',
                'rating' => 4.9,
                'album_number' => '79000',
            ],
            [
                'name' => 'Lodz Burger House',
                'latitude' => 51.7592,
                'longitude' => 19.4560,
                'category' => 'burger',
                'rating' => 4.2,
                'album_number' => '79000',
            ],
            [
                'name' => 'Szczecin Green Food',
                'latitude' => 53.4285,
                'longitude' => 14.5528,
                'category' => 'vegan',
                'rating' => 4.4,
                'album_number' => '79000',
            ],
            [
                'name' => 'Lublin Pasta Place',
                'latitude' => 51.2465,
                'longitude' => 22.5684,
                'category' => 'italian',
                'rating' => 4.7,
                'album_number' => '79000',
            ],
            [
                'name' => 'Bialystok Grill',
                'latitude' => 53.1325,
                'longitude' => 23.1688,
                'category' => 'grill',
                'rating' => 4.1,
                'album_number' => '79000',
            ],
        ]);
    }
}