jQuery(document).ready( function($){
	
$('#featured_id').on('click', function(){
	$('#featured_field').click();
})
$('#gallery_id').on('click', function(){
	$('#gallery_field').click();
})
$('#download_id').on('click', function(){
	$('#download_field').click();
})
	
$('#featured_field').on('change',  function(){
	jQuery('#submit-featured').click();
} )
$('#gallery_field').on('change',  function(){
	jQuery('#submit-gallery').click();
} )
$('#download_field').on('change',  function(){
	jQuery('#submit-download').click();
} )


/*
$('.close_button').on( 'click', function(){
	$('.featured_preview').html('');
	$('#featured_preview_input').val('');
})
*/


//########################
	var options_featured = { 
        target:        '#status',      // target element(s) to be updated with server response 
        beforeSubmit:  featuredShowRequest,     // pre-submit callback 
        success:       featuredShowResponse,    // post-submit callback 
        url:    $('#ajaxurl').val()                 // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php     
    }; 

// bind form using 'ajaxForm' 
jQuery('#featured_upload').ajaxForm( options_featured ); 

	
function featuredShowRequest(formData, jqForm,  options_featured ) {
//do extra stuff before submit like disable the submit button
jQuery('#featured_stat').html( '<img src="'+jQuery('#plugin_url').val()+'/images/loader.gif" />' );


}
function featuredShowResponse(responseText, statusText, xhr, $form)  {
	var arr =  responseText.split('|');
	$('.featured_preview').html('<img src="'+arr[1]+'" width="300" /><img src="'+jQuery('#plugin_url').val()+'/images/close-button.png" class="close_button rem_'+arr[0]+' feat_item" data-attr="'+arr[0]+'"  />');
	$('#featured_preview_input').val( arr[0] );
	jQuery('#featured_stat').html( '' );
}


//gallery ##########################
	var options = { 
        target:        '#status',      // target element(s) to be updated with server response 
        beforeSubmit:  galleryShowRequest,     // pre-submit callback 
        success:       galleryShowResponse,    // post-submit callback 
        url:    $('#ajaxurl').val()                 // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php     
    }; 

// bind form using 'ajaxForm' 
jQuery('#gallery_upload').ajaxForm(options); 

	
function galleryShowRequest(formData, jqForm, options) {
//do extra stuff before submit like disable the submit button
jQuery('#gallery_stat').html( '<img src="'+jQuery('#plugin_url').val()+'/images/loader.gif" />' );

}
function galleryShowResponse(responseText, statusText, xhr, $form)  {
	//do extra stuff after submit
	jQuery('#gallery_stat').html( '' );
	var obj = jQuery.parseJSON( responseText );
	var ids = [];
	$.each( obj, function(index) {
            
			$('.gallery_preview').html( $('.gallery_preview').html()+'<div class="single_gall_item rem_'+obj[index].id+'  gallery_item"><img src="'+obj[index].url+'" width="300"  /><img data-attr="'+obj[index].id+'" src="'+jQuery('#plugin_url').val()+'/images/close-button.png" class="close_button" /></div>');
			ids.push( obj[index].id );
        });
	
	
	$('#gallery_preview_input').val( ids.join(',') );

	
}
//######### downloadable
	var options_download = { 
        target:        '#status',      // target element(s) to be updated with server response 
        beforeSubmit:  downloadShowRequest,     // pre-submit callback 
        success:       downloadShowResponse,    // post-submit callback 
        url:    $('#ajaxurl').val()                 // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php     
    }; 

// bind form using 'ajaxForm' 
jQuery('#download_upload').ajaxForm(options_download); 

	
function downloadShowRequest(formData, jqForm, options_download) {
//do extra stuff before submit like disable the submit button
jQuery('#download_stat').html( '<img src="'+jQuery('#plugin_url').val()+'/images/loader.gif" />' );

}
function downloadShowResponse(responseText, statusText, xhr, $form)  {
	//do extra stuff after submit
	    console.log( responseText );
	jQuery('#download_stat').html( '' );
	var obj = jQuery.parseJSON( responseText );
	var urls = [];
	$.each( obj, function(index) {
            
			$('.download_preview').html( $('.download_preview').html()+'<div class="single_download_item rem_'+obj[index].id+'  download_item" data-url="'+obj[index].url+'">'+obj[index].url+'<img data-attr="'+obj[index].id+'" src="'+jQuery('#plugin_url').val()+'/images/close-button.png" class="close_button" /><div class="clearfix"></div></div>');
			urls.push( obj[index].url );
        });
	
	
	$('#download_preview_input').val( urls.join(',') );

	
}
	
}) // global end



