<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index() {
        $foods = Food::all();

        return response()->json([
            // 'success' => true,
            'foods' => $foods,
        ], 200);

        // return response()->json([
        //     "user" => $request->food()
        // ], 200);

        // return response()->json($foods);
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

        $food->save();
        return response()->json([
            'success' => true,
            'message' => 'food added successfully',
            'food' => $food
        ], 200);
    }

    public function update(Request $request) {
        $food = Food::find($request->id);
        $food->name = $request->name;
        $food->description = $request->description;
        $food->cost = $request->cost;

        $food->update();
        return response()->json([
            'success' => true,
            'message' => 'food updated successfully',
        ], 200);
    }

    public function delete(Request $request) {
        $food = Food::find($request->id);

        if ($food->photo != '') {
            Storage::delete(['public/foods'.$food->photo]);
        }

        $food->delete();
        return response()->json([
            'success' => true,
            'message' => 'food deleted successfully',
        ], 200);
    }
}
