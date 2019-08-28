<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 16:55:30
 * @@Modify Date: 2018-04-23 00:43:40
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\Brand;

class Collection{

    public $_optioncfg = 'magiccart_shopbrand';
    public $_config;
    public $_per_page = 15;
    
    public function __construct(){
        $this->_config = get_option($this->_optioncfg, '');
    }

    public function getCollection(){
        return json_decode($this->_config, true);
    }

    public function save($data){
        $data = json_encode($data);
        update_option($this->_optioncfg, $data);
    }

    /* Get Data ArrBlock */
    public function getBrands(){

        $data   = array();
        $paged  = isset($_GET['paged']) ? $_GET['paged'] : 1;
        $brands = $this->getCollection();
        $offset = ($paged - 1) * $this->_per_page;
    
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 0){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($brands as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $brandSearch[$key] = $value;
                    }
                }
                $brands = $brandSearch;
            } 
        }
        
        if(is_array($brands)){
            $brands  = array_slice($brands, $offset, $this->_per_page);
         
            $i = $offset;
            foreach($brands as $key => $value){
                $dataBrand['stt']        = $i;
                $dataBrand['name']       = $value['name'];
                $dataBrand['brand']      = isset($value['brand']) ? $value['brand'] : '';
                $dataBrand['image']      = $value['img'];
                $dataBrand['status']     = $value['status'];
                $dataBrand['key']        = $value['id'];

                $data[]                  = $dataBrand;
                $i++;
            }
        }
            
        return $data;
    }
    
    /* Count Block */
   public function totalBrands(){

        $brands = $this->getCollection();
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 0){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($brands as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $brandSearch[$key] = $value;
                    }
                }
                $brands = $brandSearch;
            } 
        }
        return count($brands);
    }   
}

