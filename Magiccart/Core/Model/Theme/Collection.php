<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 19:52:04
 * @@Modify Date: 2017-12-07 15:04:55
 * @@Function:
 */

namespace Magiccart\Core\Model\Theme;

class Collection{

    public $_optioncfg = 'magiccart_theme';
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

    /* Get Items */
    public function getItems(){

        $data           = array();
        $arrSearch      = array();
        $collection       = $this->getCollection();
        $paged          = isset($_GET['paged']) ? $_GET['paged'] : 1;
        $offset         = ($paged - 1) * $this->_per_page;
    
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 1){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($collection as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $arrSearch[$key] = $value;
                    }
                }
                $collection = $arrSearch;
            }
        }
        
        if(is_array($collection)){
            $collection  = array_slice($collection, $offset, $this->_per_page);
             
            $i = $offset;
            foreach($collection as $key => $value){
                $data_menu['name']      = $value['name'];
                $data_menu['content']   = $value['content'];
                $data_menu['status']    = $value['status'];
                $data_menu['key']       = $key;
                $data_menu['stt']       = $i;
                $data[]                 = $data_menu;
                $i++;
            }
        }
        return $data;
    }
    
    /* Count Item */
    public function getTotal(){
    
        $arrSearch= array();
        $collection = $this->getCollection();
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 1){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($collection as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $arrSearch[$key] = $value;
                    }
                }
                $collection = $arrSearch;
            }
        }
        return count($collection);
    }   
}

