<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-23 20:57:05
 * @@Modify Date: 2017-09-25 22:04:58
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Magicslider\Block\Adminhtml\Slider\Grid;
use Magiccart\Magicslider\Block\Adminhtml\Slider\Edit;
use Magiccart\Magicslider\Model\Slider\Collection;

class Slider extends Action
{
    public $_sliders;
    public $_collection;

    public function __construct()
    {
        $this->_initAction();
    }

    protected function _initAction()
    {
        add_action('admin_menu', array( $this, 'subMenu' ));
        if(!$this->is_action_page()) return;
        add_action('admin_enqueue_scripts', array( $this, 'add_admin_web' ));
        $this->_collection   = new Collection();
        $this->_sliders = $this->_collection->getCollection();
    }
    
    public function subMenu()
    {
        add_submenu_page($this->parent_slug, __('Magic Slider', "alothemes"), __('Magic Slider', "alothemes"), 'manage_options', $this->get_menu_slug(), array(
            $this,
            'indexAction'
        ));
    }
    
    public function indexAction()
    {
        $page          = $_GET['page'];
        $action        = isset($_GET['action']) ? $_GET['action'] : '';
        
        if (isset($_GET['action']) && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add')) {
            $edit = new Edit();
            $edit->addData($this->saveGroupSlider());
            echo $edit->toHtml();
        } else {
            $this->grid();
        }
        
        if ($action == 'delete') {
            $this->deleteItemGroup();
            $this->deleteGroup();
        }
        
    }
    public function grid()
    {
        $block = new Grid();
        echo $block->toHtml();
    }

    public function add_admin_web()
    {
        wp_enqueue_media();
        
        wp_register_style('magicslider', $this->get_url("adminhtml/web/css/magicslider.css"), array(), '1.0');
        wp_enqueue_style('magicslider');
        
        wp_register_script('magicslider', $this->get_url('adminhtml/web/js/magicslider.js'), '1.0');
        wp_enqueue_script('magicslider');
    }

    /* Save + Edit */
    public function saveGroupSlider(){
        $error                  = array();
        $message                = '';
        $data                   = array();
        $data['message']        = '';
        $data['group-slider']   = '';
        $strError               = '';
        $strImg                 = '';
        $groupKey               = '';

        $optionSlider           = $this->_sliders;
        
        if(!is_array($optionSlider)) $optionSlider = array();

        if($_GET['action'] == 'edit'){
            $groupKey  = isset($_GET['group']) ? $_GET['group'] : '';
            $data['group']          = isset($optionSlider[$groupKey]['name']) ? $optionSlider[$groupKey]['name'] : $groupKey;
            $data['content']        = isset($optionSlider[$groupKey]['value']) ? $optionSlider[$groupKey]['value'] : array();
            $data['key-group']      = $groupKey;
        }
    
        if(isset($_POST['submit'])){
            $groupSlider       = $_POST['group-slider'];
            $groupSliderUS     = sanitize_key($groupSlider); // sanitize_title($groupSlider);
            if(trim($groupSlider) == ''){
                $groupSlider        = "Group Slider " . rand(0, 999999);
                $groupSliderUS      = sanitize_key($groupSlider);
                
            }else if(isset($optionSlider[$groupSliderUS]) && $_GET['action'] != 'edit'){
                $error['group-slider'] = __("Group already exists !", 'alothemes');
            }
            
            if(is_numeric($groupSlider)){
                $error['group-slider'] = __("Group need at least 1 character !", 'alothemes');
            }
            
            $ids        = $_POST['ids'];
            $imgSlide   = array();
            if(count($ids) > 0){
                $arrTitle   = $_POST['title'];
                $arrDes     = $_POST['im_description'];
                $arrSrc     = $_POST['img-src'];
                $arrHref    = $_POST['img-herf'];
                $arrStatus  = isset($_POST['show-img']) ? $_POST['show-img'] : array();

                foreach ($ids as $key => $value) {
                    $imgSlide[$key]['title']         = isset($arrTitle[$value]) ? $arrTitle[$value] : '';
                    $imgSlide[$key]['description']   = isset($arrDes[$value]) ? $arrDes[$value] : '';
                    $imgSlide[$key]['src']           = isset($arrSrc[$value]) ? $arrSrc[$value] : '';
                    $imgSlide[$key]['href']          = isset($arrHref[$value]) ? $arrHref[$value] : '';
                    $imgSlide[$key]['status']        = isset($arrStatus[$value]) ? 1 : 0;
                    $imgSlide[$key]['id']            = $value;
                }
            }
    
            if(count($error) == 0){
                $group = array(
                            $groupSliderUS => array(
                                        "name"      => $groupSlider,
                                        'value'     => $imgSlide,
                                        'key-group' => $groupSliderUS,
                                    )
                        );
                $optionSlider = array_merge($optionSlider, $group);
                if($_GET['action'] == 'edit'){
                    if($groupSliderUS != $groupKey){
                        unset($optionSlider[$groupKey]);
                    }
                }
                
                $this->_collection->save($optionSlider);

                wp_redirect('?page=' . $_GET['page'] . '&action=edit&group=' . $groupSliderUS );
            }else{
                foreach($error as $key => $value){
                    $strError .=  $value . '</br>';
                }
                $message = "<div class='message error woocommerce-error'>{$strError}</div>";
            }
            $data['message']        = $message;
            $data['group']          = $groupSlider;
            $data['content']        = $imgSlide;
            $data['key-group']      = $groupSliderUS;
        }
        return $data;
    }
    
    /* Delete */
    public function deleteGroup()
    {
        $group = isset($_GET['group']) ? $_GET['group'] : '' ;
        if(! $group) return; 
        $page  = $_GET['page'];
        $optionSlider = $this->_sliders;
    
        if(isset($optionSlider[$group])) unset($optionSlider[$group]);

        $this->_collection->save($optionSlider);
    
        wp_redirect("?page=" . $page );
    }

    public function deleteItemGroup()
    {
        $group = isset($_GET['key-group']) ? $_GET['key-group'] : '';
        echo $item  = isset($_GET['group-item']) ? $_GET['group-item'] : '';

        if(! $group || ! $item ) return; 

        $page  = $_GET['page'];
        $optionSlider = $this->_sliders;
        if(isset($optionSlider[$group]['value'][$item])){
            unset($optionSlider[$group]['value'][$item]);
        }
        
        $this->_collection->save($optionSlider);
    
        wp_redirect("?page=" . $page . "&action=edit&group=" . $group );
    }
    
}
