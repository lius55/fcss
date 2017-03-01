var request = {
	ajax: function(option) {
		$.ajax({
			type: 'POST',
			url: option.url,
	    	data: option.data,
	    	cache: false,
	    	success: option.success,
	    	error: function(){
	    		if (option.error == undefined) {
	    			alert("error!");
	    		} else {
	    			return option.error;
	    		}
	    	}
		});
	}
};