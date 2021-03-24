<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Food extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'cost',
    //     'poto',
    // ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
