<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 20:12:41
 * @@Modify Date: 2017-09-13 22:31:22
 * @@Function:
 */

namespace Magiccart\Cms\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Cms\Block\Adminhtml\Block\Grid;
use Magiccart\Cms\Block\Adminhtml\Block\Edit;
use Magiccart\Cms\Model\Block\Collection;

class Block extends Action
{
    public $_blocks;
    public $_collection;

    public function __construct()
    {
        $this->_initAction();
    }
    
    protected function _initAction()
    {
        add_action('admin_menu', array($this,'subMenu'));
        if(!$this->is_action_page()) return;
        add_action('admin_enqueue_scripts', array($this,'add_admin_web'));

        $this->_collection   = new Collection();
        $this->_blocks = $this->_collection->getCollection();
    }
    
    public function subMenu()
    {
        add_submenu_page($this->parent_slug, __('Blocks', "alothemes"), __('Blocks', "alothemes"), 'manage_options', $this->get_menu_slug(), array(
            $this,
            'indexAction'
        ));
    }
    
    public function indexAction()
    {
        
        if (isset($_GET['action']) && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add')) {
            $edit = new Edit();
            $edit->addData($this->saveBlock());
            echo $edit->toHtml();
        } else {
            $block = new Grid();
            echo $block->toHtml();
        }
        
        if (isset($_GET['status'])) $this->editStatus();
        
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $this->delete();
        }  
    }
    
    public function add_admin_web()
    {
        wp_register_style('magiccart_cms', $this->get_url("adminhtml/web/css/cms.css"), array(), '1.0');
        wp_enqueue_style('magiccart_cms');
    }
    
    /* Save data + Edit */
    public function saveBlock(){
        $error                  = array();
        $message                = '';
        $data                   = array();
        $data['message']        = '';
        $data['title']          = '';
        $data['content']        = '';
        $strError               = '';
        $key                    = "";

        $blocks                 = $this->_blocks;
    
        if($_GET['action'] == 'edit'){
            $key                   = $_GET['key']; //$_GET['identifier'];
            $data['title']          = $blocks[$key]['name'];
            $data['content']        = $blocks[$key]['content'];
        }
    
        if(isset($_POST['submit'])){

            $title                  = $_POST['title'];
            $content                = $_POST['content'];
            
            $identifier = sanitize_key($title); // sanitize_title($title);
            
            if( trim($title) == null || is_numeric($title) || !$identifier ){
                $error['title'] = __("Title is not empty and require least 1 character!", 'alothemes');
            }
    
            if(trim($content) == null) $error['content'] = __("Content is require not empty !", 'alothemes');
    
            if(count($error) == 0){
                if($_GET['action'] == 'edit'){
                    $identifier = $key;
                }else {
                    if(array_key_exists($identifier, $blocks)){
                        $i = 2;
                        $orignal_id = $identifier;
                        while (array_key_exists($identifier, $blocks)) {
                            $identifier =  $orignal_id . '-' . $i;
                            $i++;
                        }
                    }
                }
                $blocks[$identifier] = array(
                    'name'      => $_POST['title'],
                    'content'   => $_POST['content'],
                    'status'    => 1
                );
                $this->_collection->save($blocks);
                $paged = max(1, $_GET['paged']);
                $continue_edit = false;
                if($continue_edit){
                    wp_redirect('?action=edit&page=' . $_GET['page'] . '&key=' . $identifier . '&paged=' . $paged );                    
                }else {
                    wp_redirect('?page=' . $_GET['page'] );
                }

            }else{
                $strError = '';
                foreach($error as $key => $value){
                    $strError .= $key . ' : ' . $value . '</br>';
                }
                $message = "<div class='error'>{$strError}</div>";
            }
            $data['message']        = $message;
            $data['title']          = $_POST['title'];
            $data['content']        = $_POST['content'];
        }
        return $data;
    }
    
    /* edit status */
    public function editStatus()
    {
        $status = $_GET['status'];
        ($status == 'unpublish' ) ? $status = 0 : $status = 1;
        $key   = $_GET['key']; //$_GET['identifier'];
        $blocks = $this->_blocks;
    
        if(isset($blocks[$key])) $blocks[$key]['status'] = $status;
        $this->_collection->save($blocks);
        $paged      = isset($_GET['paged']) ? '&paged=' . $_GET['paged'] : '';
        wp_redirect("?page=" . $_GET['page'] ."&module=cms&block=gird&model=collection&controller=block&view=gird$paged" );
    }
    
    /* Delete */
    public function delete()
    {
        $key  =  $_GET['key']; //$_GET['identifier'];
        $blocks = $this->_blocks;
        if(isset($blocks[$key])) unset($blocks[$key]);
        $this->_collection->save($blocks);
        wp_redirect("?page=" . $_GET['page']."&module=cms&block=gird&model=collection&controller=block&view=gird" );
    }

}
