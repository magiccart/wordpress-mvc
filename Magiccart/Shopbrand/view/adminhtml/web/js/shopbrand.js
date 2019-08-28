jQuery(document).ready(function($){
	var typeDefault = $("#slt-type").val();
	if(typeDefault != ''){
		var termDefault = $("#slt-term").attr('termdefault');
		loadTerm(typeDefault, termDefault);
	}

	$("#slt-type").change(function(){
		var typeAttr = $(this).val();
		loadTerm(typeAttr);
	});
	
	
	/*Upload IMG*/
	$('.img-upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#image_url').val(image_url);
            $(".image-preview").attr('src',image_url);
        });
    });


    function loadTerm(typeAttr, termDefault = ""){
    	$.ajax({
			url: ajaxurl,
			data : {
				action  	: 'load_terms',
				typeAttr	: typeAttr,
				termDefault : termDefault,
					},
			type : "POST", 
			success : function(data, status){
				if($.trim(data) == ""){
					$("#slt-term").html("<option value='-1'> -- Select Term -- </option>");
				}else{
					$("#slt-term").html(data);
				}
			}
		});
    }
	
});
