<?php
namespace Magiccart\Core\Block\Template;

class Hints {

    public $_included_files = array();

    public $_templates = array();

    public function __construct()
    {
        $this->_included_files = get_included_files(); //get_required_files() - Alias von get_included_files   
        $this->setTemplates();
    }

    // public function addConditon($data){
    //     if(is_array($data)) $this->_condition = array_merge($this->_condition, $data);
    // }

    public function getIncludeFiles($condition=''){
        $total= 0;
        if(!$condition){
            $total = count($this->_included_files);
            foreach ($this->_included_files as $filename) {
                $this->getTemplateHints($filename);
            }      
        } else {
            foreach ($this->_included_files as $filename) {
                if(strpos($filename, $condition)){
                    $this->getTemplateHints($filename);
                    $total++;
                }
            }  
        }

        echo '<h3 style="color:red;background:black;">' .$total. ' Files <b style="color:#fff;">' .$condition. '</b> included.</h3><br/>'; 
    }


    public function getShowTemplateHints(){
        return true;
    }

    public function getTemplateHints($fileName)
    {
        $html ='';
        if ($this->getShowTemplateHints()) {
            $html = '<div style="position:relative; border:1px dotted red; margin:6px 2px; padding:18px 2px 2px 2px; zoom:1;"><div style="position:absolute; left:0; top:0; padding:2px 5px; background:red; color:white; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="'.$fileName.'">'.$fileName.'</div>';
            // $thisClass = (is_object($this)) ? get_class($this) : '';
            // if($thisClass) {
            //     $html .= '<div style="position:absolute; right:0; top:0; padding:2px 5px; background:red; color:blue; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="' .$thisClass. '">' .$thisClass. '</div>';

            // }
            
            // $html .= '</div>';
   
        }

        echo $html;
    }

    public function setTemplates(){
        $included_files = $this->_included_files;
        $filter = DIRECTORY_SEPARATOR . 'themes' .DIRECTORY_SEPARATOR;
        foreach ($included_files as $key => $filename) {
            if(!strpos($filename, $filter)) unset($included_files[$key]);
        }
        $this->_templates = $included_files;

    }

    public function getTemplates($condition=''){
        $total= 0;
        if(!$condition){
            $total = count($this->_templates);
            foreach ($this->_templates as $filename) {
                $this->getTemplateHints($filename);
            }      
        } else {
            foreach ($this->_templates as $filename) {
                if(strpos($filename, $condition)){
                    $this->getTemplateHints($filename);
                    $total++;
                }
            }  
        }

        echo '<h3 style="color:red;background:black;">' .$total. ' Template <b style="color:#fff;">'.$condition.'</b> included.</h3><br/>'; 
    }

    public function getWoocommerceTemplates(){
        $this->getTemplates('woocommerce');
    }

   public function getWoocommercePlugins(){
        $filter = 'plugins' .DIRECTORY_SEPARATOR . 'woocommerce';
        $this->getIncludeFiles($filter);
    }

}
