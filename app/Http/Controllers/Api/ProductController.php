<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getExpenseByProduct(array $product){
       return DB::select(
            "SELECT warehouse.id as warehouse_id, materials.name, warehouse.remainder - product_materials.quantity*? as qty 
            FROM warehouse, materials, product_materials 
            WHERE materials.id = warehouse.material_id 
                AND materials.id = product_materials.material_id
                AND product_id IN(SELECT products.id FROM products WHERE products.name =?)
            ", 

            [$product['product_qty'],$product['product_name']]);
    }

    public function makeProduct(Request $request){

        $products = $request->products;
        $result = [];
        foreach ($products as $product)
            array_push($result, [ 
                "product_name" => $product["product_name"],
                "product_qty" => $product["product_qty"],
                "product_materials" => $this->getExpenseByProduct($product)
            ]);

        $warehouse = DB::table('warehouse')->get()->all();

        return response($result, 201);
    }
}
