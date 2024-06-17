<?php
$id = $_GET["postid"];
$postype = get_option('ecommerce');
$query = new WP_Query('post_type=product&post_id='.$id.'&posts_per_page=1');

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
?>

<form id="wpmpf_upload_image_form" method="post" action="" enctype="multipart/form-data">
  <?php wp_nonce_field('wpmpf_upload_image_form', 'wpmpf_upload_image_form_submitted'); 
 
  $posttile = get_option('posttitle');
  $postdiscription = get_option('postdiscription');
  $postauthor = get_option('postauthor');
  $postcategory= get_option('postcategory');
  $uploadimage= get_option('uploadimage');
  $posttitleenabledisables = get_option('posttitleenabledisables'); 
  $postdiscriptionenabledisable = get_option('postdiscriptionenabledisable');
  $postauthorenabledisable  = get_option('postauthorenabledisable');
  $postcategoryenabledisable = get_option('postcategoryenabledisable');
  $uploadimageenabledisable = get_option('uploadimageenabledisable');
  $posttaxonomies = get_option('posttaxonomies');
  $enablecaptcha = get_option('captchaprivatekey');
  $producttags = get_option('producttags');
  $productsaleprice = get_option('productsaleprice');
  $downloadfile = get_option('downloadfile');
  $productshortdiscription = get_option('productshortdiscription');
  $uploadgalleyenabledisable = get_option('uploadgalleyenabledisable');
  $tagsenabledisable = get_option('tagsenabledisable');
  $expertsenabledisable = get_option('expertsenabledisable');
  $downloadableenabledisable = get_option('downloadableenabledisable'); 
  $downloadablerequire = get_option('downloadablerequire'); 
  $galleryimage = get_option('galleryimage');
  $wpeditordisable = get_option('wpeditordisable'); 
  $taghelp = get_option('taghelp'); 
  $wpeditorenable = get_option('wpeditorenable');
  $posttags = get_option('posttags'); 
  ?>
  <?php 
 $woocommercevendor   = get_option('woocommercevendor');
 if ('require' == $woocommercevendor) {
  global $wpdb;
        	$table_name = $wpdb->prefix . 'usermeta'; // do not forget about tables prefix
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE meta_key = 'product_vendor'" );
    foreach ( $result as $print )   {
     
	  $current_user = wp_get_current_user();
	  
	  if($current_user->ID == $print->user_id) {
		  $table_name1 = $wpdb->prefix . 'terms'; // do not forget about tables prefix
    $result1 = $wpdb->get_results ( "SELECT * FROM ".$table_name1." WHERE term_id = ".$print->meta_value."" );
    foreach ( $result1 as $print1 )   {
		  echo '<input type="hidden" name="shop_vendor_admin" value="'.$print1->slug.'"/>';
	}
	  }
	 }
	  }
?>
  <div id="storepage">
    <div class="wp_store-product-page">
      <?php if ($posttitleenabledisables == 'disable') { } else {?>
      <label id="labels" for="wpmpf_caption">
        <?php if ( isset($posttile[0])) { echo get_option('posttitle'); } else { echo 'Post Title'; } ?>
        :</label>
      <br/>
      <input type="text" id="wpmpf_caption" name="wpmpf_caption" value=" <?php echo get_the_title($id); ?> "/>
      <br/>
      <?php } ?>
      <?php
      global $wpdb;
	  $id = $_GET["postid"];
  $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE customposition = 'top'" );
    foreach ( $result as $print )   {
    ?>
      <?php if($print->type == 'text') {  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <input type="<?php echo $print->type;?>" id="title" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="<?php echo get_post_meta( $id, $print->customfield, true ); ?>" style="width: 95%;margin: 10px auto;display: block;"/>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php   }
    elseif($print->type == 'textarea') { ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" />
              <?php echo get_post_meta( $id, $print->customfield, true ); ?>
              </textarea>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    
     elseif($print->type == 'select') {
		 $myString = $print->customvalue;
		 $myArray = explode(',', $myString);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <select name="<?php echo $print->customfield;?>" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option <?php if(get_post_meta( $id, $print->customfield, true ) == $value) {?>selected="selected"<?php } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php } ?>
              </select>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    elseif($print->type == 'checkbox')  { 
	    $myString1 = $print->customvalue;
		 $myArray1 = explode(',', $myString1);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <?php foreach ( $myArray1 as $value1 )   { ?>
              <li class="checkbox">
                <label class="selectit">
                  <input class="" <?php if(get_post_meta( $id, $print->customfield, true ) == $value1) {?>checked="checked"<?php } ?> name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
                  <?php echo $value1;?></label>
              </li>
              <?php } ?>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php  } } ?>
      <?php if ($postdiscriptionenabledisable == 'disable') { } else {?>
      <?php if ( 'disable' == $wpeditordisable ){ ?>
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>
          <?php if ( isset($postdiscription[0])) { echo get_option('postdiscription'); } else { echo 'Post Discription'; } ?>
          </span></h3>
        <div id="misc-publishing-actions">
          <textarea aria-hidden="true" class="wp-editor-area" rows="12" cols="40" style="width:94%; margin:5px auto; display:block;" name="wpmpf_content" id="wpmpf_content"><?php $post_content = get_post($id);  $content = $post_content->post_content; echo $content;  ?>
</textarea>
          <div class="clear"></div>
        </div>
      </div>
      <?php } else { ?>
      <label id="labels" for="wpmpf_caption">
        <?php if ( isset($postdiscription[0])) { echo get_option('postdiscription'); } else { echo 'Post Discription'; } ?>
        :</label>
      <br/>
      <?php $post_content = get_post($id);  $content = $post_content->post_content; wp_editor( $content, 'wpmpf_content', $settings = array('textarea_name' => 'wpmpf_content', 'media_buttons' => false) )  ; } ?>
      <br/>
      <?php } ?>
      <?php
      global $wpdb;
	  $id = $_GET["postid"];
  $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE customposition = 'description'" );
    foreach ( $result as $print )   {
    ?>
      <?php if($print->type == 'text') {  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <input type="<?php echo $print->type;?>" id="title" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="<?php echo get_post_meta( $id, $print->customfield, true ); ?>" style="width: 95%;margin: 10px auto;display: block;"/>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php   }
    elseif($print->type == 'textarea') { ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" />
              <?php echo get_post_meta( $id, $print->customfield, true ); ?>
              </textarea>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    
     elseif($print->type == 'select') {
		 $myString = $print->customvalue;
		 $myArray = explode(',', $myString);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <select name="<?php echo $print->customfield;?>" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option <?php if(get_post_meta( $id, $print->customfield, true ) == $value) {?>selected="selected"<?php } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php } ?>
              </select>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    elseif($print->type == 'checkbox')  { 
	    $myString1 = $print->customvalue;
		 $myArray1 = explode(',', $myString1);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <?php foreach ( $myArray1 as $value1 )   { ?>
              <li class="checkbox">
                <label class="selectit">
                  <input class="" <?php if(get_post_meta( $id, $print->customfield, true ) == $value1) {?>checked="checked"<?php } ?> name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
                  <?php echo $value1;?></label>
              </li>
              <?php } ?>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php  } } ?>
      <div id="woocommerce-product-data" class="postbox ">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span>Product Data :</span></h3>
        <?php if ($downloadableenabledisable == 'disable') { } else {?>
        <?php if ( 'require' == $downloadablerequire ) { ?>
        <input type="hidden" name="wpmpf_downloadable" id="downloadable" value="yes">
        <?php } else { ?>
        <div id="downloadables" class="wpmpf_half_left" style="margin-bottom: 10px; margin-top: 10px;">
          <label id="labels" for="wpmpf_caption" style="float: left; display: block">Downloadable:</label>
          <input type="checkbox" <?php $downloadableyes = get_post_meta( $id, '_downloadable', true ); if( $downloadableyes = 'yes') {?> checked="checked" name="wpmpf_downloadable" <?php } ?>style="margin: 0px 7px; padding: 0px; width: auto !important; float: left; display: block;" id="downloadable" <?php echo (isset($_POST['wpmpf_downloadable'])?"value='yes'":"value='yes'")?>>
        </div>
        <?php } ?>
        <br/>
        <?php }?>
        <div class="clear"></div>
        <?php 	if(get_option('ecommerce')== 'marketpress') {
		?>
        <script type="text/javascript">
jQuery(document).ready(function($){
	var remove = "<a href='#' class='variation_remove'>x</a>";	
 $('#addvariation').on('click', function(e){
	var add = "<tr class='variation'><td class='variationame'><input type='text' name='mp_var_name[]' value=''></td><td><input type='text' name='wpmpf_regular_price[]' value=''></td><td><input type='text' name='wpmpf_sales_price[]' value=''></td><td class='mp_var_remove'></td></tr>";		
	$("#variations").append(add);
	e.preventDefault();	
	if ($('.variation').length >1) {
  	$('.variation .mp_var_remove a').remove();
  	$(".variation:last .mp_var_remove").append(remove);
	$("#downloadables").hide();
	$("#downloadupload").hide();
	}
	$(".variationame").show();
	});	
 $('.variation_remove').on('click', function(e){
		$(this).parents('.variation').remove();
        e.preventDefault();
		if ($('.variation').size() >1)
		$(".variation:last .mp_var_remove").append(remove);
		if ($('.variation').size() == 1) {
		$(".variationame").hide();
		$("#downloadables").show();
		}
	});
	if ($('.variation').length >1) {
		$(".variationame").show();
		$("#downloadables").hide();
		$("#downloadupload").hide();
	}
});		
</script>
        <div id="variation_fields">
          <table>
            <thead>
              <tr>
                <th class="variationame">Variation Name</th>
                <th scope="col">Price </th>
                <th scope="col">Sale Price </th>
                <th scope="col"> </th>
              </tr>
            </thead>
            <tbody id="variations">
              <?php 
 
  $id = $_GET["postid"];
  
function get_meta_details( $id ) {
		$meta = get_post_custom($id);
		//unserialize
	 foreach ($meta as $key => $val) {
			 $meta[$key] = maybe_unserialize($val[0]);
			 if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file" && $key != "mp_is_special_tax" && $key != "mp_special_tax" && $key != 'mp_track_limit')
				$meta[$key] = array($meta[$key]);
		}

		$defaults = array(
			'mp_is_sale' => '',
			'mp_track_inventory' => '',
			'mp_price' => array(),
			'mp_product_link' => '',
			'mp_is_special_tax' => '',
			'mp_file' => '',
			'mp_shipping' => array(''),
			'mp_track_limit' => '',
			'mp_limit' => array(),
		);

		//Set default value if key is not already set.
		return wp_parse_args($meta, $defaults);
	}

	

        global $post;
		$meta = get_meta_details(  $id );
 if (isset($meta["mp_price"]) && $meta["mp_price"]) {
				 //if download enabled only show first variation
				 $meta["mp_price"] = (empty($meta["mp_file"]) && empty($meta["mp_product_link"])) ? $meta["mp_price"] : array($meta["mp_price"][0]);
				 $count = 1;
				 $last = count($meta["mp_price"]);

				foreach ($meta["mp_price"] as $key => $price) {
	 
					?>
              <tr class="variation">
                <td class="variationame"><input type="text" name="mp_var_name[]" value="<?php echo esc_attr($meta["mp_var_name"][$key]); ?>"></td>
                <td><input type="text" name="wpmpf_regular_price[]" value="<?php echo isset($meta["mp_price"][$key]) ? $meta["mp_price"][$key] : '0.00'; ?>"></td>
                <td><input type="text" name="wpmpf_sales_price[]" value="<?php echo isset($meta["mp_sale_price"][$key]) ? $meta["mp_sale_price"][$key] : $meta["mp_price"][$key]; ?>"></td>
                <td class="mp_var_remove"><?php if ($count == $last) { ?>
                  <a href='#' class='variation_remove'>x</a>
                  <?php } ?></td>
              </tr>
              <?php
						$count++;
					}
			 } ?>
            </tbody>
          </table>
          <br>
          <p align="right"> <a href="#" id="addvariation">Add variation</a> </p>
        </div>
        <?php 	}
	elseif(get_option('ecommerce')== 'woocommerce') {
	//this is ecommerce variation
	?>
        <div class="wpmpf_half_left">
          <label id="labels" for="wpmpf_caption">
            <?php if ( isset($productprice[0])) { echo get_option('productprice'); } else { echo 'Regular Price'; } ?>
            :</label>
          <br/>
          <input type="text" id="wpmpf_caption" name="wpmpf_regular_price" value="<?php $price = get_post_meta( $id, '_regular_price', true ); if( ! empty( $price ) ) { echo $price;}?>"/>
          <br/>
        </div>
        <div class="wpmpf_half_right">
          <label id="labels" for="wpmpf_caption">
            <?php if ( isset($productsaleprice[0])) { echo get_option('productsaleprice'); } else { echo 'Sale Price'; } ?>
            :</label>
          <br/>
          <input type="text" id="wpmpf_caption" name="wpmpf_sales_price" value="<?php $sales_price = get_post_meta( $id, '_sale_price', true ); if( ! empty( $sales_price ) ) { echo $sales_price;}?>"/>
        </div>
        <?php	} ?>
        <br/>
        <?php if ($downloadableenabledisable == 'disable') { } else {?>
        <div class="clear"></div>
        <div id="downloadupload" <?php  $downloadableyes = get_post_meta( $id, '_downloadable', true ); if ( 'require' == $downloadablerequire ) { ?> style="display:block !important; margin-left:10px;"<?php } elseif( $downloadableyes = 'yes') { echo 'style="display:block; margin-left:10px;"'; } else { ?>style="display:none; margin-left:10px;" <?php }?>>
          <label id="labels" for="wpmpf_caption" >
            <?php if ( isset($downloadfile[0])) { echo get_option('downloadfile'); } else { echo 'Download File'; } ?>
            :</label>
          <br/>
          <input type="button" value="<?php if(get_option('uploaddownloadbutton')  < '1'){ echo 'Upload Downloadable';  } else { echo get_option('uploaddownloadbutton'); };?>" id="download_id" class="<?php if ( 'require' == $downloadablerequire ) { echo 'require'; } ?>" />
          <div id="download_stat"></div>
          <div class="download_preview">
            <?php
	if(get_option('ecommerce')== 'marketpress') {
	$product = get_post_meta($id, 'mp_file', true); 
	global $wpdb;

	$basename = explode("uploads/",$product);
	$search_id = $basename[1];

    $mid = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %d AND meta_value = %s",  '_wp_attached_file', $search_id) );

  if( !empty($search_id)) {
	?>
            <div class="single_download_item rem_<?php  echo $mid;?>  download_item" data-url="<?php echo $product ?>"><?php echo $product ?><img data-attr="<?php echo $mid; ?>" src="<?php echo plugins_url( 'lib/images/close-button.png', __FILE__ ); ?>" class="close_button">
              <div class="clearfix"></div>
            </div>
            <?php 
  }
	}
	elseif(get_option('ecommerce')== 'woocommerce') {
    $product = new WC_Product($id);
	  foreach ($product->get_files() as $file_id => $file) {  ?>
            <div class="single_download_item rem_<?php echo $file['id'] ?>  download_item" data-url="<?php echo $file['file'] ?>"><?php echo $file['file'] ?><img data-attr="<?php echo $file_id; ?>" src="<?php echo plugins_url( 'lib/images/close-button.png', __FILE__ ); ?>" class="close_button">
              <div class="clearfix"></div>
            </div>
            <?php 
			 $Producturls = $file['file']; 
	   ?>
            <?php
        }
        }
	?>
          </div>
          <input style="display:none;" name="download_preview_input" id="download_preview_input" value="<?php echo $Producturls; ?>">
        </div>
        <?php }?>
        <div class="clear"></div>
      </div>
      <?php if ($expertsenabledisable == 'disable') { } else {?>
      <?php if ( 'enable' == $wpeditorenable ){ ?>
      <label id="labels" for="wpmpf_caption">
        <?php if ( isset($productshortdiscription[0])) { echo get_option('productshortdiscription'); } else { echo 'Excerpt '; } ?>
        :</label>
      <br/>
      <?php $post_excerpt = get_post($id);  $excerpt = $post_excerpt->post_excerpt; wp_editor( $excerpt, 'excerpt', $settings = array('textarea_name' => excerpt, 'textarea_rows' => 3, 'media_buttons' => false) )  ; ?>
      <?php } else {?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span>
          <?php if ( isset($productshortdiscription[0])) { echo get_option('productshortdiscription'); } else { echo 'Excerpt '; } ?>
          </span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <textarea name="excerpt" id="excerpt-post"  cols="8" rows="2"><?php $post_excerpt = get_post($id);  $excerpt = $post_excerpt->post_excerpt; echo $excerpt;?>
</textarea>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php }?>
      <?php
      global $wpdb;
	  $id = $_GET["postid"];
  $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE customposition = 'bottom'" );
    foreach ( $result as $print )   {
    ?>
      <?php if($print->type == 'text') {  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <input type="<?php echo $print->type;?>" id="title" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="<?php echo get_post_meta( $id, $print->customfield, true ); ?>" style="width: 95%;margin: 10px auto;display: block;"/>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php   }
    elseif($print->type == 'textarea') { ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" />
              <?php echo get_post_meta( $id, $print->customfield, true ); ?>
              </textarea>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    
     elseif($print->type == 'select') {
		 $myString = $print->customvalue;
		 $myArray = explode(',', $myString);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <select name="<?php echo $print->customfield;?>" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option <?php if(get_post_meta( $id, $print->customfield, true ) == $value) {?>selected="selected"<?php } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php } ?>
              </select>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    elseif($print->type == 'checkbox')  { 
	    $myString1 = $print->customvalue;
		 $myArray1 = explode(',', $myString1);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <?php foreach ( $myArray1 as $value1 )   { ?>
              <li class="checkbox">
                <label class="selectit">
                  <input class="" <?php if(get_post_meta( $id, $print->customfield, true ) == $value1) {?>checked="checked"<?php } ?> name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
                  <?php echo $value1;?></label>
              </li>
              <?php } ?>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php  } } ?>
    </div>
    <div class="wp_store-product-sidebar">
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>Update</span></h3>
        <div id="misc-publishing-actions">
          <div id="publishing-action"> <span class="spinner"></span>
            <?php  
	$enablecaptcha = get_option('enablecaptcha');
  if ($enablecaptcha == 'disable') { } else { 
	$captchapublickey = get_option('captchapublickey');
        require_once('recaptchalib.php');
  $publickey = $captchapublickey; // you got this from the signup page
  echo recaptcha_get_html($publickey);
  }
  ?>
            <input type="submit" id="wpmpf_submit" name="wpmpf_submit" value="<?php if(get_option('updatebutton')  < '1'){ echo 'Update';  } else { echo get_option('updatebutton'); };?>">
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <?php if ($postcategoryenabledisable == 'disable') { } else {?>
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>
          <?php if ( isset($postcategory[0])) { echo get_option('postcategory'); } else { echo 'Post Category'; } ?>
          </span></h3>
        <div id="misc-publishing-actions" class="categorylist">
          <?php 

class wpmpf_Walker_Category_Checklist extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $object_id = 0  ) {
		extract($args);
		if ( empty($taxonomy) )
			$taxonomy = 'category';

		if ( $taxonomy == 'category' )
			$name = 'post_category';
		else
			$name = 'tax_input['.$taxonomy.']';

		$class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->name . '" type="checkbox" name="category[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
	}

	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}



?>
          <br/>
          <?php
 $posttaxonomies = get_option('posttaxonomies');


$id = $_GET["postid"];
$cats = get_the_terms( $id, 'product_cat');

function wpmpf_category_checklist( $post_id = 0, $selected_cats = false, $tax = 'product_cat', $exclude = false ) {
    require_once ABSPATH . '/wp-admin/includes/template.php';

   $walker = new wpmpf_Walker_Category_Checklist;
 $posttaxonomies = get_option('posttaxonomies');
 $id = $_GET["postid"];

 
echo'<ul>';
     wp_terms_checklist($post_id, array(
        'taxonomy' => $posttaxonomies,
        'descendants_and_self' => 0,
        'selected_cats' => $selected_cats,
        'popular_cats' => false,
        'walker' => $walker,
        'checked_ontop' => false
    ) );
echo '</ul>';

}
   $posttaxonomies = get_option('posttaxonomies');
   wpmpf_category_checklist( $id, false,  $posttaxonomies);
?>
          <br/>
          <div class="clear"></div>
        </div>
      </div>
      <?php } ?>
      <?php if ($tagsenabledisable == 'disable') { } else {?>
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>
          <?php if ( isset($producttags[0])) { echo get_option('producttags'); } else { echo 'Product Tags'; } ?>
          </span></h3>
        <div id="misc-publishing-actions">
          <input type="text" style="width:90%; margin-left:5px; margin-top:10px;" id="wpmpf_caption" name="tags" value="<?php $id = $_GET["postid"]; $term_list = wp_get_post_terms($id, $posttags, array("fields" => "names"));  foreach($term_list as $term) {   echo $term,',';} ?>"/>
          <br/>
          <p style="margin-left:10px; margin-bottom:3px;">
            <?php if ( isset($taghelp[0])) { echo get_option('taghelp'); } else { echo 'Separate Tags with Commas'; } ?>
          </p>
          <div class="clear"></div>
        </div>
      </div>
      <?php } ?>
      <?php
      global $wpdb;
	  $id = $_GET["postid"];
  $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE customposition = 'tag'" );
    foreach ( $result as $print )   {
    ?>
      <?php if($print->type == 'text') {  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <input type="<?php echo $print->type;?>" id="title" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="<?php echo get_post_meta( $id, $print->customfield, true ); ?>" style="width: 95%;margin: 10px auto;display: block;"/>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php   }
    elseif($print->type == 'textarea') { ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" />
              <?php echo get_post_meta( $id, $print->customfield, true ); ?>
              </textarea>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    
     elseif($print->type == 'select') {
		 $myString = $print->customvalue;
		 $myArray = explode(',', $myString);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <select name="<?php echo $print->customfield;?>" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option <?php if(get_post_meta( $id, $print->customfield, true ) == $value) {?>selected="selected"<?php } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php } ?>
              </select>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php    }
    elseif($print->type == 'checkbox')  { 
	    $myString1 = $print->customvalue;
		 $myArray1 = explode(',', $myString1);
		  ?>
      <div class="postbox">
        <div class="handlediv"><br>
        </div>
        <h3 class="hndle"><span><?php echo $print->customlabel;?></span></h3>
        <div class="inside">
          <div id="postcustomstuff">
            <div id="custom_box">
              <?php foreach ( $myArray1 as $value1 )   { ?>
              <li class="checkbox">
                <label class="selectit">
                  <input class="" <?php if(get_post_meta( $id, $print->customfield, true ) == $value1) {?>checked="checked"<?php } ?> name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
                  <?php echo $value1;?></label>
              </li>
              <?php } ?>
              <p style="margin-left:10px; margin-bottom:3px;"><?php echo $print->customhelp;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php  } } ?>
      <?php if ($uploadimageenabledisable == 'disable') { } else {?>
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>
          <?php if ( isset($uploadimage[0])) { echo get_option('uploadimage'); } else { echo 'Featured Image'; } ?>
          </span></h3>
        <div id="misc-publishing-actions">
          <input type="button" value="<?php if(get_option('uploadfeaturebutton')  < '1'){ echo 'Update';  } else { echo get_option('uploadfeaturebutton'); };?>" id="featured_id" class="<?php if ( 'require' == $featurerequire ) { echo 'require'; } ?>" />
          <div id="featured_stat"></div>
          <div class="featured_preview">
            <?php if (has_post_thumbnail( $id ) ): ?>
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' ); ?>
            <img src="<?php echo $image[0]; ?>" width="300"><img src="<?php echo plugins_url( 'lib/images/close-button.png', __FILE__ ); ?>" class="close_button rem_<?php echo get_post_thumbnail_id( $id ); ?> feat_item" data-attr="<?php echo get_post_thumbnail_id( $id ); ?>">
            <?php endif; ?>
          </div>
          <input  style="display:none;"  name="featured_preview_input" id="featured_preview_input" value="<?php echo get_post_thumbnail_id( $id ); ?>">
          <div class="clear"></div>
        </div>
      </div>
      <?php } ?>

    </div>
  </div>
</form>
<?php
endwhile; endif;
?>