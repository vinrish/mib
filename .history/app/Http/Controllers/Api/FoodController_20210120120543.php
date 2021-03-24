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

        if ($request->photo != '') {
            $photo = time().'jpg';
            file_put_contents('storage/foods'.$photo,base64_decode($request->photo));
            $food->photo = $photo;
        }

        $photo->save();
        return response()->json([
            'success' => true,
            'message' => 
        ], 200);
    }
}
