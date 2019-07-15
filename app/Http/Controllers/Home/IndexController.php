<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Index_type_detail;
use App\Index_type;
use App\Banner;
use App\Promotion_information;
use App\Index_information;
use App\Sell_good;
use App\Recovery_good;
use App\Product_information;
use App\Product_informations_img;

class IndexController extends Controller
{
    //获取回收产品信息
    private function get_recovery_good($id){
        
            $recovery_good = Recovery_good::find($id);
            $recovery_good['product_information'] = Product_information::find($recovery_good->product_information_id);
            $recovery_good['promotion_information'] = Product_information::find( $recovery_good->promotion_information_id);
            $recovery_good['img'] = Product_informations_img::where('product_information_id',$recovery_good->product_information_id)->get();
            return $recovery_good;
        
    }

    //获取售出产品信息
    private function get_sell_good($id){
        if(is_array($id)){   
            for($i=0;$i<count($id);$i++){
                $more[$i] = Sell_good::find($id[$i]);
                $more[$i]['product_information']=Product_information::find($more[$i]->product_information_id); 
                $more[$i]['promotion_information']=Promotion_information::find($more[$i]->promotion_information_id);  
                $more[$i]['img']=Product_informations_img::where('product_information_id',$more[$i]->product_information_id)->get(); 
            }
            return $more;
        }else{
            $sell_good = Sell_good::find($id);
            $sell_good['product_information'] =Product_information::find( $sell_good->product_information_id);
            $sell_good['promotion_information'] = Promotion_information::find( $sell_good->promotion_information_id);
            $sell_good['img'] = Product_informations_img::where('product_information_id', $sell_good->product_information_id)->get();
            return $sell_good;
        }
    }
    //首页推荐页面信息
    public function index(){
        $index_information = Index_information::find(1);     
        $index=[];
        $index['banner'] = Banner::find($index_information->banner_id);
        $index['countdown'] = Promotion_information::find($index_information->promotion_information_id);
        $index['sell_good'] = $this->get_sell_good($index_information->sell_good_id);
        $index['recovery_good'] =  $this->get_recovery_good($index_information->recovery_good_id);
        $index_more = explode(',',$index_information->more); 
        $index['more'] =  $this->get_sell_good( $index_more);
        $index_hot_active = explode(',',$index_information->hot_active);
        //热门活动
        for($i=0;$i<count($index_hot_active);$i++){
            $index['hot_active'][$i] =  Banner::find($index_hot_active[$i]);
        }
        //公益活动
        $index_public_welfare = explode(',',$index_information->public_welfare);
        for($i=0;$i<count($index_public_welfare);$i++){
            $index['public_welfare'][$i] =  Banner::find($index_public_welfare[$i]);
        }
        //合作伙伴
        $index['cooperative_partner'] = Banner::find($index_information->cooperative_partner);
       
        return $index;
    }

   

    //首页分类类信息
    public function index_type(){
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
    //获取首页加
}
