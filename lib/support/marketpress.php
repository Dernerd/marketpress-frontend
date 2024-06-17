<?php
      //wordpress category submission 
	  $posttaxonomies = get_option('posttaxonomies');
	  $posttags = get_option('posttags'); 
	  $tags = array($_POST['tags']);
	  $post_category = (isset($_POST['category'])) ? array_filter((array) $_POST['category']) : array();
      wp_set_object_terms($post_id, $post_category, $posttaxonomies);
	  wp_set_object_terms($post_id, 'simple', 'product_type');
	  wp_set_post_terms( $post_id, $tags, $posttags);
     
	  //custom field
	  global $wpdb;
      $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
      $result = $wpdb->get_results ( "SELECT * FROM ".$table_name."" );
      foreach ( $result as $print )
	  {
		  if($print->type == checkbox)
		  {
			  $checkboxs =  (isset($_POST[$print->customfield])) ? array_filter((array) $_POST[$print->customfield]) : array();
			  update_post_meta($post_id, $print->customfield, $checkboxs);
		  }
		  else
		 {
			  update_post_meta($post_id, $print->customfield, $_POST[$print->customfield]);
	     }
	  }
	  
      update_post_meta($post_id, 'mp_var_name',sanitize_title($_POST['mp_var_name']));
      update_post_meta($post_id, 'mp_sku', array(''));
	  $func_curr = '$price = round(preg_replace("/[^0-9.]/", "", $price), 2);return ($price) ? $price : 0;';
	  update_post_meta($post_id, 'mp_price', array_map(create_function('$price', $func_curr), (array)$_POST['wpmpf_regular_price']));
      if ($_POST['wpmpf_sales_price'] == NULL) { 
      }
	  else { 
	  $price2 = $_POST['wpmpf_sales_price'];
	  update_post_meta($post_id, 'mp_is_sale', 1);
		 }
	  update_post_meta($post_id, 'mp_sale_price', array_map(create_function('$price', $func_curr), (array)$_POST['wpmpf_sales_price']));
	    		if ($_POST['wpmpf_sales_price'] == NULL) { 
		 }
		else { 
	  update_post_meta($post_id, 'mp_price_sort', $_POST['wpmpf_sales_price']);
		 }
      update_post_meta($post_id, 'mp_track_inventory', 0);
      update_post_meta($post_id, 'mp_inventory', '');
	  update_post_meta($post_id, 'mp_product_link', '');
	  update_post_meta($post_id, 'mp_is_special_tax', '0');
	  update_post_meta($post_id, 'mp_special_tax', '0');
	  update_post_meta($post_id, 'mp_sales_count', '0');
	  update_post_meta($post_id, 'mp_shipping', array('0'));
      $b = $_POST['download_preview_input'];
      update_post_meta($post_id, 'mp_file', $b);
	  $galleryimagesuploadid = $_POST['featured_preview_input'];
      update_post_meta($post_id, '_thumbnail_id', $galleryimagesuploadid);
	  $featureimagesuploadid = $_POST['gallery_preview_input'];
      update_post_meta($post_id, '_product_image_gallery', $featureimagesuploadid);
	  
	  
	  
	  

?>