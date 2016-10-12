

/*防止二次提交，加入提交后等待提示框blockUI*/
$(document).ready(function() {
	/*修改blockui默认设置*/
	$.blockUI.defaults.message = '<img src="/images/busy1.gif" />';
	//$.blockUI.defaults.css = {border:"0px",backgroundColor:"none"};
	$.blockUI.defaults.css.border = "0px";
	$.blockUI.defaults.css.backgroundColor = "none";
	
	$('form').on('beforeValidate', function (e) {
		//$.blockUI();
	});
	$('form').on('afterValidate', function (e) {
	    if (cheched = $(this).data('yiiActiveForm').validated == false) {
	    	$.unblockUI();
	    }
	}); 
	$('form').on('beforeSubmit', function (e) {
		$.blockUI();
	});
}).ajaxStart($.blockUI).ajaxStop($.unblockUI);

