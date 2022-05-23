<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // what materials was used from which warehause and how much
    protected $usedMaterialsHistory = [];

    // The actual list of warehoses to be used (for each material)
    protected $actualWarehouseForMaterials = [];

    // save reports about changes
    protected $materialsUsed = [];

    // 
    protected $usedWarehouseIDs = array( 
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
    );


    //
    public function getMaterials(object $materialNeeded){

        // get actual warehouse for this: $material (from where to get)

        $warehouseToUse = $this->getActualWarehouse($materialNeeded);
        if($warehouseToUse){
            // getting...
            $warehouse = DB::table('warehouse')
                            ->join('materials', 'warehouse.material_id', '=', 'materials.id')
                            ->where('warehouse.id', $warehouseToUse['warehouse_id'])
                            ->get(['warehouse.id AS warehouse_id','materials.name AS material_name','warehouse.remainder AS qty','price'], )
                            ->first();                   

            if($warehouse->qty >= $materialNeeded->qty){
                $warehouse->qty = $warehouse->qty - $materialNeeded->qty;

                // save used materials to report
                array_push($this->materialsUsed, $warehouse);

                $warehouse->qty = $materialNeeded->qty;
                
            }else{
                // calculate new $qty by subtructing used materials // make qty positive by * (-1)
                $materialNeeded->qty = -1 * ($warehouse->qty - $materialNeeded->qty); 

                 // save used materials to report
                array_push($this->materialsUsed, $warehouse);
               
                $this->usedWarehouseIDs[$materialNeeded->id] = $warehouse->warehouse_id;

                $this->getMaterials($materialNeeded);
            }
        }else{

            return false;
        }


    }

    // get actual warehouse ID for this: $material
    public function getActualWarehouse(object $material){ 

        // history of used materils yet
        $wID = $this->usedWarehouseIDs[$material->id];
        

        // get first shipped group of matterials
        $warehouse = DB::table('warehouse')
            ->where([['material_id', $material->id], ['id', '>', $wID]])
            ->first();
        if($warehouse)
            return [
                'warehouse_id' => $warehouse->id
            ];
        else
            return False;
    }

    // change actual warehouse ID to get this: $material
    public function changeActualWarehouse(object $material){
        // array_push($actualWarehouseForMaterials => $material->id); 
    }

    public function getFromWarehouse(array $materials){ 

        foreach($materials as $material){
            do{           
                //need Materils? -> getting...    
                $needMoreMaterils = $this->getMaterials($material);

                // keep getting while we get enough materials 
            }while ($needMoreMaterils);

 
        }
        // report used materils
        return $this->materialsUsed;
    }

    public function getExpenseByProduct(array $product){

        // get product ID by product name 
        $productID = DB::table('products')->where('name', $product['product_name'])->get()->first();

        $productQty = $product['product_qty'];

        // calculate and get total materials needed for this: $productQty amount of products
        $materials = DB::select(
            DB::RAW("
                    SELECT materials.id, materials.name, quantity * $productQty AS qty 
                    FROM materials, product_materials 
                    WHERE product_id = $productID->id 
                            AND materials.id = product_materials.material_id"));

        // now get materials for this: $product from warehouse
        return $this->getFromWarehouse($materials);
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
