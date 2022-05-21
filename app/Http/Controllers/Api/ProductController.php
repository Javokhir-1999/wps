<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//  Models
use App\Models\Material;
use App\Models\Product;
use App\Models\Warehouse;


class ProductController extends Controller
{
    public function makeProduct(Request $request){

        $products = $request->products;

        return response($products, 201);
    }
}
