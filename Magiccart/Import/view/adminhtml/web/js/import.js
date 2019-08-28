jQuery(document).ready(function($){
	$("#select_action").change(function(){
		
		var select_action = $(this).val();
		if(select_action == "import"){
			console.log("none");
			$(".model-images").css({"display" : "none"});
		}else{
			$(".model-images").css({"display" : "block"});
			$(".model-images input").removeAttr("checked");
		}

		$.ajax({
			url: ajaxurl,
			data : {
				action  	 : 'load_page',
				selectAction : select_action,
					},
			type : "POST", 
			success : function(data, status){
				if($.trim(data) == ""){
					$("#select_page").html("<option value='-1'> -- Data Empty -- </option>");
				}else{
					$("#select_page").html(data);
				}
			}
		});
	});
});