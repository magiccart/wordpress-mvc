/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-18 22:06:02
 * @@Modify Date: 2018-01-18 17:19:19
 * @@Function:
 */

(function($){
    /*Upload IMG single*/
    $('img.img-avatar').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
           
            var image_url = uploaded_image.toJSON().url;
            jQuery('#image_url').val(image_url);
            jQuery(".img-avatar").attr('src',image_url);
        });
    });

    function sortItem(){
        $('.sortable').sortable({
            update: function(event, ui) {
                
            }
        });
        $( ".sortable" ).disableSelection();
        $( ".sortable .grid-item" ).mousedown(function(){
            $(this).css({'cursor' : 'all-scroll'});
        });
        $( ".sortable .grid-item" ).mouseup(function(){
            $(this).css({'cursor' : 'auto'});
        });
    }

    jQuery(document).ready(function($){
        /*Sort Slider*/
    sortItem();

    var custom_uploader;
      $('#upload-btn-slider').click(function(e) {
        //function sortItem(){ return false; };
        e.preventDefault();
        var uploader = $(this);
        if (custom_uploader) {
          custom_uploader.open();
          return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose Image',
          button: {
            text: 'Choose Image'
          },
          multiple: true
        });
        custom_uploader.on('select', function() {
          var selection = custom_uploader.state().get('selection');
          selection.map( function( attachment ) {
            image = attachment.toJSON();
            var id     = image.id;
            var url    = image.url;
            // var str    = image.link;
            // var basUrl = str.replace(image.name, '');
            var src    = uploader.data('url') + '/wp-admin/upload.php?item='+ image.id ;
            
            var xhtml  = '<li class="grid-item" data-id="'+ id +'" >';
                xhtml +=        '<a target="_blank" class="mg-ifame" href="'+ src +'"><img class="img-avatar" src="'+ url +'"></a>';
                xhtml +=    '<div class="image-options">';
                xhtml +=        '<div>';
                xhtml +=            '<input class="text_area title-img" type="text" name="title['+ id +']" value="" placeholder="Title">';
                xhtml +=        '</div>';
                xhtml +=        '<div class="description-block">';
                xhtml +=            '<textarea  name="im_description['+ id +']" placeholder="Caption"></textarea>';
                xhtml +=        '</div>';
                xhtml +=        '<div class="link-block">';
                xhtml +=            '<input class="text_area" type="text" name="img-herf['+ id +']" placeholder="URL" value="">';
                xhtml +=        '</div>';
                xhtml +=        '<div class="img-show">';
                xhtml +=            '<label class="lbl-show" >Hide image : </label>';
                xhtml +=            '<input  class="link_target" type="checkbox" name="show-img['+ id +']">';
                xhtml +=        '</div>';
                xhtml +=        '<div class="remove-image-container">';
                xhtml +=            '<a class="button remove-image" href="#">Remove Image</a>';
                xhtml +=        '</div>';
                xhtml +=    '</div>';
                xhtml +=            '<input class="src-img" type="text" name="img-src['+ id +']" value="'+ url +'">';
                xhtml +=   '<input class="id-img" type="text" name="ids['+ id +']" value="'+ id +'">';
                xhtml += '</li>';

            $(".grid-img").append(xhtml);
          });
        });
        custom_uploader.open();
      });

      $('.edit-name').click(function(){
            $(".name-slide input").toggle(500);
      });
});

})(jQuery);




