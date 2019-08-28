jQuery(document).ready(function($){
   

    $(document).on('click', '.magiccart-button-img', function(e) {
        var idName = $(this).attr('idbtn');
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            
            var image_url = uploaded_image.toJSON().url;
            $('.magiccart-picture').val(image_url);
            
        });
    });
    
});