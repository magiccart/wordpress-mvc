<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-24 10:26:08
 * @@Modify Date: 2017-08-24 11:50:06
 * @@Function:
 */

namespace Magiccart\Core\Block\Adminhtml;

use Magiccart\Core\Block\Adminhtml\Template;

class Grid extends \WP_List_Table{

	private $_template;

	public function __construct()
	{
		$this->_template = new Template;
	}

	// fake "extends C" using magic function
	public function __call($method, $args)
	{
		return $this->_template->$method($args);
	}

    public function toHtml(){
        return $this->_template->toHtml();
    }

}
