<?php
namespace App\Services\Ads;


class SearchService{
    /**
     * @param string $category
     * @return array
     */
    public function getCategoryName(string $category):array{
        if($category=='apartment'){
            $page='APARTMENTS';
            $pagear='شقق';
        }elseif($category=='villa'){
            $page='VILLAS';
            $pagear='فيلات';
        }elseif($category=='land'){
            $page='LANDS';
            $pagear='أراضى';
        }elseif($category=='houses'){
            $page='HOMES';
            $pagear='بيوت';
        }elseif($category=='shop'){
            $page='SHOPS';
            $pagear='محلات تجارية';
        }elseif($category=='chalet'){
            $page='CHALETS';
            $pagear='شاليهات';
        }else{
            $page='Error In URL';
            $pagear='خطأ بالرابط';
        }
        return [$page,$pagear];
    }
}
