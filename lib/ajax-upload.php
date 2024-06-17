<?php

add_Action('wp_footer', 'ta_footer_injection');
function ta_footer_injection()
{
    global $post;
    
    echo '
	
		<div class="hidden">
		<form id="featured_upload" method="post" action="#" enctype="multipart/form-data" >
			<input type="file" name="featured" id="featured_field"  multiple="false" >
			' . wp_nonce_field('name_of_my_action', 'name_of_nonce_field', true, false) . '
			<input type="hidden" name="action" id="action" value="featured_action">
		  <input id="submit-featured" name="submit-ajax" type="submit" value="upload">
		</form>
		<form id="gallery_upload" method="post" action="#" enctype="multipart/form-data" >
			<input type="file" name="gallery[]" id="gallery_field"  multiple="true" >
			' . wp_nonce_field('name_of_my_action', 'name_of_nonce_field', true, false) . '
			<input type="hidden" name="action" id="action" value="gallery_action">
		  <input id="submit-gallery" name="submit-ajax" type="submit" value="upload">
		</form>
    <form id="download_upload" method="post" action="#" enctype="multipart/form-data" >
			<input type="file" name="gallery[]" id="download_field"  multiple="true" >
			' . wp_nonce_field('name_of_my_action', 'name_of_nonce_field', true, false) . '
			<input type="hidden" name="field_type"  value="downloadable">
      <input type="hidden" name="action" id="action" value="gallery_action">
		  <input id="submit-download" name="submit-ajax" type="submit" value="upload">
		</form>
		<div id="status"></div>
		</div>
		<script>
		function remove_attach( id ){
	
				
				var data = {
  					action: "remove_attach",
					id: id,
  					security: \'' . wp_create_nonce("security_nonce") . '\'
  				};

  				  jQuery.ajax({url: \'' . get_option('home') . '/wp-admin/admin-ajax.php\',
  					  type: "POST",
  					  data: data,            
  					  beforeSend: function(msg){
						jQuery("#status_ajax").fadeIn();

  					   },
  						success: function(msg){
		
							if( msg == "1" ){

								if( jQuery(".rem_"+id).hasClass("feat_item") ){
									jQuery(".featured_preview").html("");
									jQuery("#featured_preview_input").val("");
								}else if(  jQuery(".rem_"+id).hasClass("single_gall_item") ){
									jQuery(".rem_"+id).replaceWith("");
									var arr = jQuery("#gallery_preview_input").val().split(",");

									arr = jQuery.grep(arr, function(value) {
									  return value != id;
									});
									jQuery("#gallery_preview_input").val( arr.join(",") );
								}else{
                    jQuery(".rem_"+id).replaceWith("");
									  var url_arr = [];
                    jQuery(".download_preview .single_download_item").each( function(){
                           url_arr.push( jQuery(this).attr("data-url") );
                    })
     
                  jQuery("#download_preview_input").val( url_arr.join(",") );
									
                }
							
							}
  						} , 
  					  error:  function(msg) {
  						alert("Error Saved!!: " + msg);
  					  }          
  			  });
        }
		jQuery(document).ready( function($){
			jQuery(".close_button").on( "click", function(){
				jQuery(this).attr( "src", jQuery("#plugin_url").val()+"/images/loader.gif"  );
				remove_attach( jQuery(this).attr("data-attr") );
			} )
			
		})
    
    
    // checking of submit
     jQuery("#wpmpf_submit").click(function(e){
              
              var error = 0;
              jQuery(".req_error").removeClass("req_error");
              
              if(  jQuery("#title").hasClass("require") && !jQuery("#title").val() ){
                 jQuery("#title").addClass("req_error");
                 error = 1;
              }
			  
			 if(  jQuery("#wpmpf_content").hasClass("require") && !jQuery("#wpmpf_content").val() ){
                 jQuery("#wpmpf_content").addClass("req_error");
                 error = 1;
              } 
			   
                  /*
              if(  jQuery("#wpmpf_file").hasClass("require") && !jQuery("#wpmpf_file").val() ){
                 jQuery("#wpmpf_file").addClass("req_error");
                 error = 1;
              }
                  */
              if(  jQuery("#excerpt-post").hasClass("require") && !jQuery("#excerpt-post").val() ){
                 jQuery("#excerpt-post").addClass("req_error");
                 error = 1;
              }
                   

              if(  !jQuery("#category").attr("checked") && jQuery("#category").hasClass("require") ){
				  var chks = document.getElementsByName("category[]");
				  var hasChecked = false;
				  for (var i = 0; i < chks.length; i++)
				  {
					  if (chks[i].checked)
					  {
						  hasChecked = true;
						  break;
					   }
				   }
					   if (hasChecked == false)
					   {
						   jQuery("#category").parents("#misc-publishing-actions").addClass("req_error");
						   error = 1;
					    }
					}
              
              if(  jQuery("#featured_id").hasClass("require")  ){
                  if( !jQuery("#featured_preview_input").val() ){
                           jQuery("#featured_id").addClass("req_error");
                           error = 1;
                  }
              }
              if( jQuery("#gallery_id").hasClass("require")  ){
                  if( !jQuery("#gallery_preview_input").val() ){
                           jQuery("#gallery_id").addClass("req_error");
                           error = 1;
                  }
              }
              
              if( jQuery("#download_id").hasClass("require")  ){
                  if( !jQuery("#download_preview_input").val() ){
                           jQuery("#download_id").addClass("req_error");
                           error = 1;
                  }
              }
              
               if( jQuery("#tags_list").hasClass("require") && !jQuery("#tags_list").val() ){
                           jQuery("#tags_list").addClass("req_error");
                           error = 1; 
              }
              
              
                
              if( error == 1 ){
                  e.preventDefault();
              }
              
     })
	 
    
		</script>

		';
    
}


add_action('wp_ajax_remove_attach', 'tp_remove_attach');
add_action('wp_ajax_nopriv_remove_attach', 'tp_remove_attach');
function tp_remove_attach()
{
    global $email, $wpdb;
    
    if (check_ajax_referer('security_nonce', 'security')) {
        if (get_post_type($_POST['id']) == 'attachment') {
            $src_full = wp_get_attachment_image_src($_POST['id'], 'full');
            $path_arr = explode('/', $src_full[0]);
            $num      = count($path_arr);
            $num      = $num - 1;
            $uploads  = wp_upload_dir();
            $path     = $uploads['basedir'] . '/' . $path_arr[$num - 2] . '/' . $path_arr[$num - 1] . '/' . $path_arr[$num];
            unlink($path);
            if (wp_delete_attachment($_POST['id'], true)) {
                echo '1';
				if(get_option('ecommerce')== 'marketpress') {
				$id = $_GET["postid"];
				$product = get_post_meta($id, 'mp_file', true); 
	global $wpdb;
  $mid = $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $id, 'mp_file') );
            }
			 }
        }
    }
    die();
}

add_action('wp_footer', 'tp_footer_injection');
function tp_footer_injection()
{
    echo '<input type="hidden" id="ajaxurl" value="' . get_option('home') . '/wp-admin/admin-ajax.php" />';
    echo '<input type="hidden" id="plugin_url" value="' . plugins_url('', __FILE__) . '" />';
}

add_action('wp_ajax_featured_action', 'my_featured_upload');
add_action('wp_ajax_nopriv_featured_action', 'my_featured_upload');

function my_featured_upload()
{
    //simple Security check
    //var_dump( $_REQUEST );var_dump( $_POST );
    if (wp_verify_nonce($_POST['name_of_nonce_field'], 'name_of_my_action')) {
        
        //get POST data
        $post_id = $_POST['post_id'];
        
        //require the needed files
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        //then loop over the files that were sent and store them using  media_handle_upload();
        
        
        if (get_image_type($_FILES['featured']["tmp_name"])) {
            
            $uploads    = wp_upload_dir();
            $subdir_arr = explode('/', $uploads[subdir]);
            @mkdir($uploads['basedir'] . '/' . $subdir_arr[1], 0777);
            @mkdir($uploads['basedir'] . $uploads[subdir], 0777);
			
            $checkpath = $uploads[path] . '/'  . $_FILES['featured']["name"];
			
			if (file_exists($checkpath)) {
								$i = '';
				$image_path = $uploads[path] . '/'.$i.''  . $_FILES['featured']["name"];
				while(file_exists($image_path)) {
				 $image_path = $uploads[path] . '/'.$i.''  . $_FILES['featured']["name"];
                  $image_url  = $uploads[url] . '/'.$i.'' . $_FILES['featured']["name"];
				$i++;
				}
			}
			
			else {
				            $image_path = $uploads[path] . '/'  . $_FILES['featured']["name"];
            $image_url  = $uploads[url] . '/' . $_FILES['featured']["name"];
			}
            
            //unlink( $image_path );
            copy($_FILES['featured']["tmp_name"], $image_path);
            //unlink( $img_old_path );
            
            
            $filetype = wp_check_filetype($image_path);
            // Set up an array of args for our new attachment
            $args     = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => $news_image, // you may want something different here
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            // Insert the attachment!
            $thumb_id = wp_insert_attachment($args, $image_path, 1);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $metadata = wp_generate_attachment_metadata($thumb_id, $image_path);
            wp_update_attachment_metadata($thumb_id, $metadata);
            
            // Finally! set our post thumbnail
            
            
            
        }
        
        echo $thumb_id . '|' . $image_url;
    }
    die();
}
add_action('wp_ajax_gallery_action', 'gallery_action_upload');
add_action('wp_ajax_nopriv_gallery_action', 'gallery_action_upload');

function gallery_action_upload()
{
    //simple Security check
    //var_dump( $_REQUEST );var_dump( $_POST );
    if (wp_verify_nonce($_POST['name_of_nonce_field'], 'name_of_my_action')) {
        
        //get POST data
        $post_id = $_POST['post_id'];
        
        //require the needed files
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        //then loop over the files that were sent and store them using  media_handle_upload();
        $uploads = wp_upload_dir();
        
        fixFilesArray($_FILES['gallery']);
        foreach ($_FILES['gallery'] as $singe_file) {
            
            $run = 0;
            if ($_POST["field_type"] == "downloadable") {
                
                
                if (substr_count($singe_file["name"], '.php') == 0 && substr_count($singe_file["name"], '.js') == 0) {
                    $run = 1;
                }
            }
            
            //var_dump( get_image_type( $singe_file["tmp_name"] )  );
            // var_dump( $run );
            if (get_image_type($singe_file["tmp_name"]) || $run == 1) {
                
                $patched_name = sanitize_file_name($singe_file["name"]);
                
                $uploads    = wp_upload_dir();
                $subdir_arr = explode('/', $uploads[subdir]);
                @mkdir($uploads['basedir'] . '/' . $subdir_arr[1], 0777);
                @mkdir($uploads['basedir'] . $uploads[subdir], 0777);
                
				            $checkpath = $uploads[path] . '/' . $patched_name;
			
			if (file_exists($checkpath)) {
				$i = '';
				$image_path = $uploads[path] . '/'.$i.'' . $patched_name;
				while(file_exists($image_path)) {
                $image_path = $uploads[path] . '/'.$i.'' . $patched_name;
                $image_url  = $uploads[url] . '/'.$i.'' . $patched_name;
				$i++;
				}
		
            
			}
			else {
                $image_path = $uploads[path] . '/' . $patched_name;
                $image_url  = $uploads[url] . '/' . $patched_name;
			}
                
                
                //unlink( $image_path );
                copy($singe_file["tmp_name"], $image_path);
                //unlink( $img_old_path );
                
                
                $filetype = wp_check_filetype($image_path);
                // Set up an array of args for our new attachment
                $args     = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => $news_image, // you may want something different here
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                // Insert the attachment!
                $thumb_id = wp_insert_attachment($args, $image_path, 1);
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $metadata = wp_generate_attachment_metadata($thumb_id, $image_path);
                wp_update_attachment_metadata($thumb_id, $metadata);
                $arr[] = array(
                    'id' => $thumb_id,
                    'url' => $image_url
                );
            }
        }
        echo json_encode($arr);
        
    }
    die();
}


add_action('wp_print_scripts', 'at_add_script_fn');
function at_add_script_fn()
{
    
    if (is_admin()) {
        
    } else {
        wp_enqueue_script('jquery-form', array(
            'jquery'
        ), false, true);
        wp_enqueue_script('at_front_js', plugins_url('/js/front.js', __FILE__), array(
            'jquery'
        ), '1.0');
        wp_enqueue_style('at_front_css', plugins_url('/css/front.css', __FILE__));
    }
}


function get_image_type($file)
{
    if (!$f = @fopen($file, 'rb')) {
        return false;
    }
    
    $data = fread($f, 8);
    fclose($f);
    
    if (@array_pop(unpack('H12', $data)) == '474946383961' || @array_pop(unpack('H12', $data)) == '474946383761') {
        return 'GIF';
    } else if (@array_pop(unpack('H4', $data)) == 'ffd8') {
        return 'JPEG';
    } else if (@array_pop(unpack('H16', $data)) == '89504e470d0a1a0a') {
        return 'PNG';
    }
    
    return false;
}
function fixFilesArray(&$files)
{
    $names = array(
        'name' => 1,
        'type' => 1,
        'tmp_name' => 1,
        'error' => 1,
        'size' => 1
    );
    foreach ($files as $key => $part) {
        // only deal with valid keys and multiple files
        $key = (string) $key;
        if (isset($names[$key]) && is_array($part)) {
            foreach ($part as $position => $value) {
                $files[$position][$key] = $value;
            }
            // remove old key reference
            unset($files[$key]);
        }
    }
}

?>