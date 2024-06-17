<form id="wpmpf_upload_image_form" method="post" action="" enctype="multipart/form-data">
  <p id="test-div1" class="status"></p>
  <p id="test-div1" class="discription"></p>
  <?php wp_nonce_field('wpmpf_upload_image_form', 'wpmpf_upload_image_form_submitted'); ?>
  <?php 
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
  $titlerequire = get_option('titlerequire'); 
  $discriptionrequire = get_option('discriptionrequire'); 
  $categoryrequire = get_option('categoryrequire'); 
  $featurerequire = get_option('featurerequire'); 
  $galleryrequire = get_option('galleryrequire'); 
  $tagsrequire = get_option('tagsrequire'); 
  $expertrequire = get_option('expertrequire'); 
  $galleryimage = get_option('galleryimage');
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
        <?php if ( isset($posttile[0])) { echo get_option('posttitle'); } else { echo 'Product Title'; } ?>
        :</label>
      <br/>
      <input type="text" id="title" class="wpmpf_caption <?php if ( 'require' == $titlerequire ) { echo 'require'; } ?>" name="wpmpf_caption" value="<?php $wpmpf_caption ; ?>"/>
      <br/>
      <?php } ?>
      <?php
      global $wpdb;
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
              <input type="<?php echo $print->type;?>" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="" style="width: 95%;margin: 10px auto;display: block;"/>
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
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value=""/>
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
              <select name="<?php echo $print->customfield;?>" class="<?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option value="<?php echo $value;?>"><?php echo $value;?></option>
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
                  <input class="<?php if ( $print->customrequire == 'yes') { echo 'require'; } ?>" name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
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
          <textarea aria-hidden="true" class="wp-editor-area <?php if ( 'require' == $discriptionrequire ) { echo 'require'; } ?>" rows="12" cols="40" style="width:94%; margin:5px auto; display:block;" name="wpmpf_content" id="wpmpf_content"></textarea>
          <div class="clear"></div>
        </div>
        <?php if ( 'require' == $discriptionrequire ) { $requireclass = 'require'; } else { $requireclass = 'notrequire'; }?>
      </div>
      <?php } else { ?>
      <label id="labels" for="wpmpf_caption">
        <?php if ( isset($postdiscription[0])) { echo get_option('postdiscription'); } else { echo 'Post Discription'; } ?>
        :</label>
      <br/>
      <?php wp_editor( '', 'wpmpf_content', $settings = array('textarea_name' => 'wpmpf_content', 'media_buttons' => false, 'editor_class'=> ( 'require' == $discriptionrequire ) ? 'require' : 'notrequire') )  ; } ?>
      <?php } ?>
      <?php
      global $wpdb;
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
              <input type="<?php echo $print->type;?>" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="" style="width: 95%;margin: 10px auto;display: block;"/>
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
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value=""/>
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
              <select name="<?php echo $print->customfield;?>" class="<?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option value="<?php echo $value;?>"><?php echo $value;?></option>
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
                  <input class="<?php if ( $print->customrequire == 'yes') { echo 'require'; } ?>" name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
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
        <div class="wpmpf_half_left" id="downloadables" style="margin-bottom: 10px; margin-top: 10px;">
          <label id="labels" for="wpmpf_caption" style="float: left; display: block">Downloadable:</label>
          <input type="checkbox" name="wpmpf_downloadable" style="margin: 0px 7px; padding: 0px; width: auto !important; float: left; display: block;" id="downloadable" <?php echo (isset($_POST['wpmpf_downloadable'])?"value='yes'":"value='yes'")?>>
        </div>
        <?php } ?>

        <br/>
        <?php }?>
        <div class="clear"></div>

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
              <tr class="variation">
                <td class="variationame"><input type="text" name="mp_var_name[]" value=""></td>
                <td><input type="text" name="wpmpf_regular_price[]" value=""></td>
                <td><input type="text" name="wpmpf_sales_price[]" value=""></td>
                <td class="mp_var_remove"></td>
              </tr>
            </tbody>
          </table>
          <br>
          <p align="right"> <a href="#" id="addvariation">Add variation</a> </p>
        </div>
    
        <br/>
        <?php if ($downloadableenabledisable == 'disable') { } else {?>
        <div class="clear"></div>
        <div id="downloadupload" <?php if ( 'require' == $downloadablerequire ) { ?> style="display:block !important; margin-left:10px;"<?php } else { ?>style="display:none; margin-left:10px;" <?php }?>>
          <label id="labels" for="wpmpf_caption" >
            <?php if ( isset($downloadfile[0])) { echo get_option('downloadfile'); } else { echo 'Download File'; } ?>
            :</label>
          <br/>
          <input type="button" value="<?php if(get_option('uploaddownloadbutton')  < '1'){ echo 'Upload File';  } else { echo get_option('uploaddownloadbutton'); };?>" id="download_id" class="<?php if ( 'require' == $downloadablerequire ) { echo 'require'; } ?>" />
          <div id="download_stat"></div>
          <div class="download_preview"></div>
          <input style="display:none;" name="download_preview_input" id="download_preview_input" >
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
      <?php if ( 'require' == $expertrequire ) { $requireclasss = 'require'; } else { $requireclasss = 'notrequire'; }?>
      <?php wp_editor( $content, 'excerpt', $settings = array('textarea_name' => excerpt, 'textarea_rows' => 3, 'media_buttons' => false, 'editor_class'=> $requireclass) )  ; ?>
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
              <textarea name="excerpt" class="<?php if ( 'require' == $expertrequire ) { echo 'require'; } ?>" id="excerpt-post"  cols="8" rows="2"></textarea>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php }?>
      <?php
      global $wpdb;
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
              <input type="<?php echo $print->type;?>" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="" style="width: 95%;margin: 10px auto;display: block;"/>
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
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value=""/>
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
              <select name="<?php echo $print->customfield;?>" class="<?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option value="<?php echo $value;?>"><?php echo $value;?></option>
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
                  <input class="<?php if ( $print->customrequire == 'yes') { echo 'require'; } ?>" name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
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
        <h3 class="wp_storehpost"><span>Publish</span></h3>
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
            <input type="submit" id="wpmpf_submit" name="wpmpf_submit" value="<?php if(get_option('submitbutton')  < '1'){ echo 'Publish';  } else { echo get_option('submitbutton'); };?>">
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <?php if ($postcategoryenabledisable == 'disable') { } else {?>
      <div class="postbox ">
        <h3 class="wp_storehpost"><span>
          <?php if ( isset($postcategory[0])) { echo get_option('postcategory'); } else { echo 'Post Category'; } ?>
          </span></h3>
        <div id="misc-publishing-actions" class="categorylist"> <br/>
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
		$categoryrequire = get_option('categoryrequire');
		if ( empty($taxonomy) )
			$taxonomy = 'category';

		if ( $taxonomy == 'category' )
			$name = 'post_category';
		else
			$name = 'tax_input['.$taxonomy.']';
            
		$class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->name . '" type="checkbox" name="category[]" id="category" class="'.( $categoryrequire ==  'require' ? 'require' : '' ).'"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled(  ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
	}

	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}



?>
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
          <input id="tags_list" type="text" style="width:90%; margin-left:5px; margin-top:10px;" class="wpmpf_caption <?php if ( 'require' == $tagsrequire ) { echo 'require'; } ?>" name="tags" value="<?php $wpmpf_tags ; ?>"/>
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
              <input type="<?php echo $print->type;?>" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value="" style="width: 95%;margin: 10px auto;display: block;"/>
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
              <textarea id="excerpt-post" rows="2" cols="8" class="wpmpf_caption <?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>" name="<?php echo $print->customfield;?>" value=""/>
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
              <select name="<?php echo $print->customfield;?>" class="<?php if ( 'yes' == $print->customrequire ) { echo 'require'; } ?>">
                <?php foreach ( $myArray as $value )   { ?>
                <option value="<?php echo $value;?>"><?php echo $value;?></option>
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
                  <input class="<?php if ( $print->customrequire == 'yes') { echo 'require'; } ?>" name="<?php echo $print->customfield;?>[]" value="<?php echo $value1;?>" type="checkbox">
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
          <input type="button" value="<?php if(get_option('uploadfeaturebutton')  < '1'){ echo 'Upload Feature';  } else { echo get_option('uploadfeaturebutton'); };?>" id="featured_id" class="<?php if ( 'require' == $featurerequire ) { echo 'require'; } ?>" />
          <div id="featured_stat"></div>
          <div class="featured_preview"></div>
          <input  style="display:none;"  name="featured_preview_input" id="featured_preview_input" >
          <div class="clear"></div>
        </div>
      </div>
      <?php } ?>
    
    </div>
  </div>
  <?php wp_nonce_field( 'ajax-add-nonce', 'securitys' ) ?>
</form>
