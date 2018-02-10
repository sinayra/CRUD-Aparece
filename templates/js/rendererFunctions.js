function loadMain(url){
	var req = $.ajax({
        url         :  url,
        type        : 'get'
    });

    req.done(function( data ) {
    	$('main').html(data);      
    });
}