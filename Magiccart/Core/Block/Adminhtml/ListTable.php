<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-24 11:52:57
 * @@Modify Date: 2018-06-06 11:43:39
 * @@Function:
 */

namespace Magiccart\Core\Block\Adminhtml;
	
class ListTable extends  \WP_List_Table{

    protected $_per_page = 15;
    protected $total_items = 0;
    // public $items = array();
    public function __construct(){

        $args = array(
            'plural' 	=> 'magiccart-grid',
			'singular' 	=> 'magiccart-grid'
        );
        
        parent::__construct($args);
    }
    
    /* return columns header */
    public function get_columns(){
        $columnHeader = array(
            'stt'           => 'STT',
            'name'          => 'Name',
            'image'    		=> 'Image',
            'published'     => 'Published',
            'edit'          => 'Edit',
        	'action'        => 'Action'
        );

        return $columnHeader;
    }
    
    /* return columns hidden */
    public function get_hidden_columns(){
        return array();
    }
    
    /* return columns sortable */
    public function get_sortable_columns(){
        return array(
            
        );
    }
   
    public function prepare_items(){
 
        $this->_column_headers = array(
                $this->get_columns(), 
                $this->get_hidden_columns(), 
                $this->get_sortable_columns()
            );
        
        $totalPages = ceil($this->total_items/$this->_per_page);
        $this->set_pagination_args(
                array(
                    'total_items' => $this->total_items,
                    'per_page'    => $this->_per_page,
                    'total_pages' => $totalPages
                )
            );
    }
    
    public function column_stt($item)
    {
        return $item['stt']+1;
    }

    public function column_name($item)
    {
        $page       = $_GET['page'];
        $xhtml      = "<a href='?page={$page}&key={$item['key']}&module={$this->_module}&action=edit'>{$item['name']} </a>";
        return $xhtml;
    }

    public function column_term($item)
    {
        if($item['term'] == -1) return " ";
    	$term = ucfirst($item['term']);
    	return $term;
    }

    public function column_image($item)
    {
    	$page       = $_GET['page'];
        $img = "<a href='?page={$page}&key={$item['key']}&module={$this->_module}&action=edit'><img width='100px' height='35px' src='{$item['image']}' /></a>";
    	
    	return $img;
    }

    public function column_published($item)
    {
        if($item['status']){
            $show    = 'publish';
            $action = 'unpublish';
        }else{
            $show    = 'unpublish';
            $action = 'publish';
        }
        $page  = $_GET['page'];
        $paged      = isset($_GET['paged']) ? '&paged=' . $_GET['paged'] : '';
        $xStatus = "<a class='{$show}' href='?page={$page}&status={$action}&key={$item['key']}{$paged}' ></a>";
        return $xStatus;
    }

    public function column_action($item)
    {
    	$page = $_GET['page'];
    	$xAction = "<a class='del-action' title='delete' href='?page={$page}&action=delete&key={$item['key']}' ></a>";
    	return $xAction;
    }

    public function column_edit($item)
    {
        $page       = $_GET['page'];
        $paged      = isset($_GET['paged']) ? '&paged=' . $_GET['paged'] : '';
        $xhtml      = "<a href='?page={$page}&key={$item['key']}&action=edit$paged'>" . __('Edit', 'alothemes') . "</a>";
        return $xhtml;
    }

}
