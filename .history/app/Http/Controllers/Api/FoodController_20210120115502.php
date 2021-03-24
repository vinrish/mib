<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index() {
        $food = DB::table('food')->get();
        return $food;
    }

    public function create(Request $request) {
        $food = new Food;
        $food->name = $request->name;
        $food->description = $request->description;
        $food->cost = $request->cost;
    }
}
