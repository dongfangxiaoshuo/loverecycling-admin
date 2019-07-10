<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Brand;
use App\Recycled_model;

class CategoryController extends Controller
{
    public function index(Request $request){
        $type =  $request->input('type');
        $brand_name = Brand::where('brand_type',$type)->get();
        return $brand_name;
    }
    public function productInformation(Request $request){
        
        $brand =  $request->input('brand');
        $type =  $request->input('type');
        // $brand==0为推荐
        if($brand==0){
            //推荐为另一个表
        }

        $product = Recycled_model::where("brand_id",$brand)->get();

        return $product;



    }
}
