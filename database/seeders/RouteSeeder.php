<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
  public function run(): void
  {
    $routes = [
      ['route_name' => 'University Route', 'start_point' => 'Sweileh', 'end_point' => 'University of Jordan', 'region_id' => 1],
      ['route_name' => 'Downtown Route', 'start_point' => 'Jabal Amman', 'end_point' => 'Downtown', 'region_id' => 1],
      ['route_name' => 'Irbid Campus Route', 'start_point' => 'City Center', 'end_point' => 'Yarmouk University', 'region_id' => 2],
      ['route_name' => 'North Route', 'start_point' => 'Irbid North', 'end_point' => 'Bus Station', 'region_id' => 2],
      ['route_name' => 'Zarqa Industrial Route', 'start_point' => 'City Center', 'end_point' => 'Industrial Area', 'region_id' => 3],
      ['route_name' => 'Zarqa University Route', 'start_point' => 'City Center', 'end_point' => 'Hashemite University', 'region_id' => 3],
      ['route_name' => 'Balqa Route', 'start_point' => 'Salt', 'end_point' => 'Balqa University', 'region_id' => 4],
      ['route_name' => 'Salt Downtown Route', 'start_point' => 'Salt', 'end_point' => 'Downtown Amman', 'region_id' => 4],
      ['route_name' => 'Madaba Route', 'start_point' => 'Madaba', 'end_point' => 'Mount Nebo', 'region_id' => 5],
      ['route_name' => 'Madaba Amman Route', 'start_point' => 'Madaba', 'end_point' => 'Amman Downtown', 'region_id' => 5],
    ];

    foreach ($routes as $route) {
      Route::create($route);
    }
  }
}
