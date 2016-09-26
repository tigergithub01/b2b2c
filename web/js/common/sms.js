/**
 * 
 */

$(function() {
	//获取短信验证码
	$(".btn_sms").click(function() {
		
		var obj = $(this);
		//console.debug($(this));
		
		//调用发送短信验证码URL		
		$.ajax({     
    	    url:$(this).attr('url'),     
    	    type:'post',  
    	    dataType:'json', 
    	    data:{'verify_code':$("#vip-verify_code").val(),"vip_id":$("#vip-vip_id").val()},     
    	    async :true, 
    	    error:function(err){
    	    	alert('验证码获取失败！'+err.responseJSON.message);
    	    },     
    	    success:function(data){ 
    		    if(data.status){
    		    	settime(obj);
    		    	alert(data.message);
    		    }else{
    		    	alert(data.message);
    		    }
    	    }  
    	}); 		
	});

});

//获取验证码间隔时间为60秒
var countdown = 60;
function settime(obj) {
	if (countdown == 0) {
		obj.attr('disabled',false);
		obj.val('获取验证码');
		countdown = 60;
		return;
	} else {
		obj.attr('disabled',true);
		obj.val("重新发送(" + countdown + ")");
		countdown--;
	}
	setTimeout(function() {
		settime(obj)
	}, 1000)
}





