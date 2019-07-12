<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Index_type_detail;
use App\Index_type;
use App\Banner;

class IndexController extends Controller
{
    public function index(){
        $index_type = Index_type::all();
        for($i=0;$i<count($index_type);$i++){
            $index_type[$i]->headlines=$this->getBanner($index_type[$i]->banner); 
            $index_type[$i]->tab=$this->getTags($index_type[$i]->id);
        }
        
        return $index_type;
    }
    //获取广告
    private function getBanner($index_type_banners){
        $index_type_banner = explode(',',$index_type_banners); 
        for($i=0;$i<count($index_type_banner);$i++) 
        { 
            $banner =Banner::find($index_type_banner);
        }
        
       return $banner;
    }
    //获取分类详情
    private function getTags($index_type_id){
        $tags = Index_type_detail::where('index_type_id',$index_type_id)->get();
        return $tags;
    }
}
