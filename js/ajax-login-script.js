jQuery(document).ready(function($) {

    // Show the login dialog box on click

    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $('#loginform p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val() },
            success: function(data){
               
                if (data.loggedin == true){
					$('#loginform p.status').hide();
					$('#loginform div.loginerror').hide();
					 $('#loginform div.loginsuccess').show().text(data.message);
                    document.location.href = ajax_login_object.redirecturl;
                }
				else if(data.loggedin == false) {
					$('#loginform p.status').hide();
					 $('#loginform div.loginsuccess').hide();
					$('#loginform div.loginerror').show().text(data.message);
				}
            }
        });
        e.preventDefault();
    });

});