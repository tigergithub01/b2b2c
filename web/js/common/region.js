
$(function(){
	$(".clsRegion").change(function(){
		var ref_elment_id = $(this).attr("sub_id");
		var id = $(this).val();
		getSubRegionList($(this).attr("url"), id, ref_elment_id);
	});
	
});


/**
 * 获取下级区域
 * @param id
 */
function getSubRegionList(req_url , id, ref_elment_id){
	$.ajax({     
	    url: req_url,     
	    type:'get',  
	    dataType:'json', 
	    data: {"id": id},     
	    async: true, 
	    error:function(err){
	    	if(err!=null && err.responseJSON!=null){
	    		alert('获取数据失败！'+err.responseJSON.message);
	    		$("#txt_api_return").val(err.responseJSON.message);
	    	}
	    },   
	    success:function(data){ 
		    if(data.status){
		    	var selObj = $("#"+ref_elment_id);
		    	selObj.empty();
		    	selObj.append("<option value=''>--请选择--</option>");
		    	$.each(data.value,function(i,v){
		    		selObj.append("<option value='"+v.id+"'>"+v.name+"</option>");
        		});		    	
		    	selObj.change();
		    }else{
		    	alert(data.message);
		    }
	    }  
	}); 
}

