<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class APIController extends Controller
{
    public function getProducts(){
        $products= Products::all();
        return response()->json($products);
    }
    public function getOneProduct($id)
{
$product = Products::find($id);
return response()->json($product);
}
public function addProduct(Request $request)
{
$product = new Products();
$product->name = $request->input('name');
$product->image = $request->input('image');
$product->description = $request->input('description');
$product->unit_price = intval($request->input('unit_price'));
$product->promotion_price = intval($request->input('promotion_price'));
$product->unit = $request->input('unit');
$product->new = intval($request->input('new'));
$product->id_type = intval($request->input('id_type'));
$product->save();
return $product;
}
public function deleteProduct($id)
{
$product = Products::find($id);
$fileName = '/image/product/' . $product->image;
if (File::exists($fileName)) {
File::delete($fileName);
}
$product->delete();
return ['status' => 'ok', 'msg' => 'Delete successed'];
}
public function editProduct(Request $request, $id)
{
$product = Products::find($id);
 
$product->name = $request->input('name');
$product->image = $request->input('image');
$product->description = $request->input('description');
$product->unit_price = intval($request->input('unit_price'));
$product->promotion_price = intval($request->input('promotion_price'));
$product->unit = $request->input('unit');
$product->new = intval($request->input('new'));
$product->id_type = intval($request->input('id_type'));
 
$product->save();
return response()->json(['status' => 'ok', 'msg' => 'Edit successed']);
}
 
    public function uploadImage(Request $request){
        // process image
        if ($request->hasFile('uploadImage')) {
            $file = $request->file('uploadImage');
            $fileName = $file->getClientOriginalName();
 
            $file->move('/image/product', $fileName);
 
            return response()->json(["message" => "ok"]);
    }
    else return response()->json(["message" => "false"]);
    }
    public function searchByName(Request $request)
    {
        if($request->keyword == null)
        {
            return DB::all();
        }
        $result = DB::table('products')
                ->where('name', 'like', "% $request->keyword %")
                ->get();
        return $result;
    }

    //
}
